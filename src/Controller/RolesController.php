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

/**
 * @Route("/admin")
 */
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
     * @Route("/roles", name="index_roles")
     * @IsGranted("ROLES_VER")
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
     * @Route("/roles/{id}", name="show_role", requirements={"id":"\d+"})
     * @IsGranted("ROLES_VER")
     */
    public function show(Request $request, Role $rol)
    {
        /* Niega el acceso a ver info der rol superuser sin ser superuser */
        if(!$this->actionOnSuperUser($rol)){
            $this->addFlash("danger", "No tienes suficientes permiso para realizar esa acción.");
            return $this->redirectToRoute("index_roles");
        }
        return $this->render('admin/roles/show.html.twig', [
            'rol' => $rol
        ]);
    }

    /**
     * @Route("/roles/new",name="new_role")
     * @IsGranted("ROLES_CREAR")
     */
    public function new(Request $request){
        $form = $this->createForm(RoleFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){            
            $rol = $form->getData();

            /* Validación de que no exista un rol con ese nombre */
            if($this->rolesRepository->findByName($rol->getRoleName())){
                $this->addFlash("danger","Ya existe un rol con ese nombre.");
                return $this->render("admin/roles/new.html.twig", ["form"=>$form->createView()]);
            }elseif(str_contains("ROLE_SUPERUSER", $this->rolesRepository->findAll())){
                $this->addFlash("danger","No puede utilizar este nombre en el rol.");
                return $this->render("admin/roles/new.html.twig", ["form"=>$form->createView()]);
            }

            $this->entityManager->persist($rol);
            $this->entityManager->flush();
            $this->addFlash("success","Rol creado correctamente.");
            return $this->redirectToRoute("index_roles");

        }
        return $this->render("admin/roles/new.html.twig", ["form"=>$form->createView()]);
    }

    /**
     * @Route("/roles/edit/{id}",name="edit_role", requirements={"id":"\d+"})
     * @IsGranted("ROLES_EDITAR")
     */
    public function edit(Role $rol, Request $request){

        /* Niega el acceso a ver info der rol superuser sin ser superuser */
        if(!$this->actionOnSuperUser($rol)){
            $this->addFlash("danger", "No tienes suficientes permiso para realizar esa acción.");
            return $this->redirectToRoute("index_roles");
        }

        $form = $this->createForm(RoleFormType::class,$rol);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            
            /* Validación de que no exista un rol con ese nombre */
            if($this->rolesRepository->findRepetido($rol)){
                $this->addFlash("danger","Ya existe un rol con ese nombre.");
                return $this->render("admin/roles/new.html.twig", ["form"=>$form->createView()]);
            }

            $this->entityManager->persist($rol);
            $this->entityManager->flush();
            $this->addFlash("success","Rol modificado correctamente.");
            return $this->redirectToRoute("index_roles");
        }
        return $this->render("admin/roles/new.html.twig", ["form"=>$form->createView()]);
    }   

    /**
     * @Route("/roles/delete/{id}",name="delete_role", requirements={"id":"\d+"})
     * @IsGranted("ROLES_ELIMINAR")
     */
    public function delete(Request $request, Role $rol){

        /* Niega el acceso a ver info der rol superuser sin ser superuser */
        if(!$this->actionOnSuperUser($rol)){
            $this->addFlash("danger", "No tienes suficientes permiso para realizar esa acción.");
            return $this->redirectToRoute("index_roles");
        }

        if ($this->isCsrfTokenValid('delete'.$rol->getId(), $request->request->get('_token'))) {
            $resp = $this->rolesRepository->delete($rol);
            if($resp === true){
                $this->addFlash("success","Rol eliminado correctamente.");
            }else{
                $this->addFlash("danger","Error al eliminar el rol.");
            }
        }
        return $this->redirectToRoute('index_roles');          
    }

    private function actionOnSuperUser(Role $rol){
        if($rol->getRoleName() == "ROLE_SUPERUSER" && $this->getUser()->getRoles()[0] != "ROLE_SUPERUSER"){
           return false;
        }else{
            return true;
        }
    }
    
}
