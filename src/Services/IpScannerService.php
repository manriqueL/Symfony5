<?php
// src/Service/IpScannerService.php

namespace App\Service;

use App\Entity\Ip;
use App\Entity\ScanLog;
use Doctrine\ORM\EntityManagerInterface;

class IpScannerService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function scanIps()
    {
        // Recupera todas las IPs de la base de datos
        $ips = $this->entityManager->getRepository(Ip::class)->findAll();
        foreach ($ips as $ip) {
            $ipAddress = $ip->getIpAddress();
            $result = shell_exec("ping -n 1 $ipAddress");
            $isActive = strpos($result, "Packets: Sent = 1, Received = 1, Lost = 0 (0% loss)") !== false;
            if ($result === null) {
                echo "Error en la ejecución del comando de ping.";
            } 

            // Actualiza el estado de la IP
            $ip->setIsActive($isActive);

            if ($ip->getIsActive()) {
                // La IP se ha vuelto a activar, actualiza la fecha de la última desactivación
                $timezone = new \DateTimeZone('America/Argentina/La_Rioja');
                $lastDeactivatedAt = new \DateTime('now', $timezone);
                $ip->setLastDeactivatedAt($lastDeactivatedAt);
            }
            // Crea un registro de escaneo
            $scanLog = new ScanLog();
            $scanLog->setIp($ip);
            $scanLog->setIsActive($isActive);
            $scanLog->setScannedAt(new \DateTime());

            // Persiste los cambios en la base de datos
            $this->entityManager->persist($ip);
            $this->entityManager->persist($scanLog);
        }

        // Guarda los cambios en la base de datos
        $this->entityManager->flush();
    }
}
