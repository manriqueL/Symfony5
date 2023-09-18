<?php
// src/Controller/YourController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\IpScannerService;
use App\Entity\Ip; // Asegúrate de importar la entidad Ip

class IpController extends AbstractController
{
    private $ipScannerService;

    public function __construct(IpScannerService $ipScannerService)
    {
        $this->ipScannerService = $ipScannerService;
    }

    /**
     * @Route("/ips", name="ip_list")
     */
    public function list(): Response
    {
        // Recupera las IPs desde la base de datos
        $entityManager = $this->getDoctrine()->getManager();
        $ips = $entityManager->getRepository(Ip::class)->findAll();
        $this->ipScannerService->scanIps();
        // Renderiza la plantilla Twig con los datos de las IPs
        return $this->render('ips/list.html.twig', [
            'ips' => $ips,
            
        ]);
    }
}