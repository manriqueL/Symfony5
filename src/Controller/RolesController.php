<?php


namespace App\Controller;


use App\Entity\Role;
use App\Form\RoleFormType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\roles\FiltroType;

class RolesController extends BaseController
{

    private $rolesRepository;
    private $entityManager;
    private $paginator;

    public function __construct(RoleRepository $rolesRepository,EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->rolesRepository = $rolesRepository;
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
    }


    /**
     * @Route("/admin/roles", name="index_roles")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function index(Request $request){

        $formFiltro = $this->createForm(FiltroType::class);
        if ($request->query->get($formFiltro->getName())) {
            $formFiltro->handleRequest($request);
        }
        $objOptions = $formFiltro->getData();
        
        $pagination = $this->paginator->paginate(
            $this->rolesRepository->findForActionIndex($objOptions),
            $request->query->get('page', 1),
            12
        );
        return $this->render("admin/roles/index.html.twig",[
            "pagination"=>$pagination,
            'formFiltro' => $formFiltro->createView()
        ]);
    }

    /**
     * @Route("/admin/roles/{id}", name="show_role", requirements={"id":"\d+"})
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function show(Request $request, Role $rol)
    {    
        return $this->render('admin/roles/show.html.twig', [
            'rol' => $rol
        ]);
    }

    /**
     * @Route("/admin/roles/new",name="new_role")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function new(Request $request){
        $form = $this->createForm(RoleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $rol = $form->getData();
            $this->entityManager->persist($rol);
            $this->entityManager->flush();
            $this->addFlash("success-nuevo","");
            return $this->redirectToRoute("index_roles");

        }
        return $this->render("admin/roles/new.html.twig", ["form"=>$form->createView()]);
    }

    /**
     * @Route("/admin/roles/edit/{id}",name="edit_role", requirements={"id":"\d+"})
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function edit(Role $rol, Request $request){
        $form = $this->createForm(RoleFormType::class,$rol);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($rol);
            $this->entityManager->flush();
            $this->addFlash("success-modificado","");
            return $this->redirectToRoute("index_roles");
        }
        return $this->render("admin/roles/new.html.twig", ["form"=>$form->createView()]);
    }   

    /**
     * @Route("/admin/roles/delete/{id}",name="delete_role", requirements={"id":"\d+"})
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function delete(Request $request, Role $rol){
        if ($this->isCsrfTokenValid('delete'.$rol->getId(), $request->request->get('_token'))) {
            $resp = $this->rolesRepository->delete($rol);
            if($resp === true){
                $this->addFlash("success-eliminado","");
            }else{
                $this->addFlash("error-eliminado","");
            }
        }
        return $this->redirectToRoute('index_roles');          
    }
    
}
