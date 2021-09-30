<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InicioController extends AbstractController
{

    /**
     * @Route("/",name="inicio_index")
     */
    public function index(){
        if($this->getUser()){
            return $this->render("inicio/index.html.twig");
        }else{
            return $this->redirectToRoute("app_login");
        }
        
    }

}
