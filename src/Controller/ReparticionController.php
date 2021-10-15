<?php


namespace App\Controller;


use App\Entity\Reparticion;
use App\Form\ReparticionFormType;
use App\Repository\ReparticionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\reparticion\FiltroType;

class ReparticionController extends BaseController
{

    private $reparticionRepository;
    private $entityManager;
    private $paginator;

    public function __construct(ReparticionRepository $reparticionRepository,EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->reparticionRepository = $reparticionRepository;
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
    }


    /**
     * @Route("/admin/reparticion", name="index_reparticion")
     * @IsGranted("REPARTICION_VER")
     */
    public function index(Request $request){

        $formFiltro = $this->createForm(FiltroType::class);
        if ($request->query->get($formFiltro->getName())) {
            $formFiltro->handleRequest($request);
        }
        $objOptions = $formFiltro->getData();
        
        $pagination = $this->paginator->paginate(
            $this->reparticionRepository->findForActionIndex($objOptions),
            $request->query->get('page', 1),
            12
        );
        return $this->render("admin/reparticion/index.html.twig",[
            "pagination"=>$pagination,
            'formFiltro' => $formFiltro->createView()
        ]);
    }

    /**
     * @Route("/admin/reparticion/{id}", name="show_reparticion", requirements={"id":"\d+"})
     * @IsGranted("REPARTICION_VER")
     */
    public function show(Request $request, Reparticion $reparticion)
    {    
        return $this->render('admin/reparticion/show.html.twig', [
            'reparticion' => $reparticion
        ]);
    }

    /**
     * @Route("/admin/reparticion/new",name="new_reparticion")
     * @IsGranted("REPARTICION_CREAR")
     */
    public function new(Request $request){
        $form = $this->createForm(ReparticionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $reparticion = $form->getData();
            $this->entityManager->persist($reparticion);
            $this->entityManager->flush();
            $this->addFlash("success-nuevo","");
            return $this->redirectToRoute("index_reparticion");

        }
        return $this->render("admin/reparticion/new.html.twig", ["form"=>$form->createView()]);
    }

    /**
     * @Route("/admin/reparticion/edit/{id}",name="edit_reparticion", requirements={"id":"\d+"})
     * @IsGranted("REPARTICION_EDITAR")
     */
    public function edit(Reparticion $reparticion, Request $request){
        $form = $this->createForm(ReparticionFormType::class,$reparticion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($reparticion);
            $this->entityManager->flush();
            $this->addFlash("success-modificado","");
            return $this->redirectToRoute("index_reparticion");
        }
        return $this->render("admin/reparticion/new.html.twig", ["form"=>$form->createView()]);
    }   

    /**
     * @Route("/admin/reparticion/delete/{id}",name="delete_reparticion", requirements={"id":"\d+"})
     * @IsGranted("REPARTICION_ELIMINAR")
     */
    public function delete(Request $request, Reparticion $reparticion){
        if ($this->isCsrfTokenValid('delete'.$reparticion->getId(), $request->request->get('_token'))) {
            $resp = $this->reparticionRepository->delete($reparticion);
            if($resp === true){
                $this->addFlash("success-eliminado","");
            }else{
                $this->addFlash("error-eliminado","");
            }
        }
        return $this->redirectToRoute('index_reparticion');          
    }
    
}
