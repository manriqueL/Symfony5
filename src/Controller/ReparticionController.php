<?php


namespace App\Controller;


use App\Entity\Reparticion;
use App\Form\ReparticionFormType;
use App\Repository\ReparticionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReparticionController extends BaseController
{

    private $reparticionRepository;
        private $entityManager;

    public function __construct(ReparticionRepository $reparticionRepository,EntityManagerInterface $entityManager)
    {
        $this->reparticionRepository = $reparticionRepository;
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/admin/reparticion", name="index_reparticion")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function index(){
        $reparticion = $this->reparticionRepository->findAll();
        return $this->render("admin/reparticion/index.html.twig",["reparticiones"=>$reparticion]);
    }

    /**
     * @Route("/admin/reparticion/new",name="new_reparticion")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function new(Request $request){
        $form = $this->createForm(ReparticionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $reparticion = $form->getData();
            $this->entityManager->persist($reparticion);
            $this->entityManager->flush();
            $this->addFlash("success","Repartición creada correctamente!");
            return $this->redirectToRoute("index_reparticion");

        }
        return $this->render("admin/reparticion/new.html.twig", ["form"=>$form->createView()]);
    }

    /**
     * @Route("/admin/reparticion/edit/{id}",name="edit_reparticion")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function edit(Reparticion $reparticion, Request $request){
        $form = $this->createForm(ReparticionFormType::class,$reparticion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($reparticion);
            $this->entityManager->flush();
            $this->addFlash("success","Repartición modificada correctamente!");
            return $this->redirectToRoute("index_reparticion");
        }
        return $this->render("admin/reparticion/new.html.twig", ["form"=>$form->createView()]);
    }   

    /**
     * @Route("/admin/reparticion/delete/{id}",name="delete_reparticion")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function delete(Request $request, Reparticion $reparticion){
        if ($this->isCsrfTokenValid('delete'.$reparticion->getId(), $request->request->get('_token'))) {
            $resp = $this->reparticionRepository->delete($reparticion);
            if($resp === true){
                $this->addFlash('success', '¡Registro eliminado correctamente!');
            }else{
                $this->addFlash('error', '¡Error al eliminar el registro!');
            }
        }
        return $this->redirectToRoute('index_reparticion');          
    }
    
}
