<?php

// src/Entity/ScanLog.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="scan_logs")
 */
class ScanLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ip", inversedBy="scanLogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ip;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $scannedAt;

    // Getters and setters for isActive and scannedAt

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?Ip
    {
        return $this->ip;
    }

    public function setIp(?Ip $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getScannedAt(): ?\DateTimeInterface
    {
        return $this->scannedAt;
    }

    public function setScannedAt(\DateTimeInterface $scannedAt): self
    {
        $this->scannedAt = $scannedAt;

        return $this;
    }
}
