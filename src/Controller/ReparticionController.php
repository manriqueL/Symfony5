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
    public function delete(Reparticion $reparticion){
        /*$this->addFlash("success","Utilisateur supprimé");
        return $this->redirectToRoute('index_reparticion');*/
        //$eliminar = $this->reparticionRepository->delete($reparticion);
        $eliminar = true;
        
        if($eliminar){
            $this->addFlash("success","Repartición eliminada");
            return $this->redirectToRoute('index_reparticion', array(["message" => "success"]));
        }else{
            $this->addFlash("danger","Error al eliminar la repartición");
            return $this->redirectToRoute('index_reparticion');
        }        
    }
}
