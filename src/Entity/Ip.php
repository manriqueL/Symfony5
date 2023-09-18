<?php

// src/Entity/Ips.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ips")
 */
class Ip
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastDeactivatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ScanLog", mappedBy="ip")
     */
    private $scanLogs;

    public function __construct()
    {
        $this->scanLogs = new ArrayCollection();
    }

    // Getters and setters for ipAddress, isActive, and lastDeactivatedAt

    /**
     * @return Collection|ScanLog[]
     */
    public function getScanLogs(): Collection
    {
        return $this->scanLogs;
    }

    public function addScanLog(ScanLog $scanLog): self
    {
        if (!$this->scanLogs->contains($scanLog)) {
            $this->scanLogs[] = $scanLog;
            $scanLog->setIp($this);
        }

        return $this;
    }

    public function removeScanLog(ScanLog $scanLog): self
    {
        if ($this->scanLogs->contains($scanLog)) {
            $this->scanLogs->removeElement($scanLog);
            // set the owning side to null (unless already changed)
            if ($scanLog->getIp() === $this) {
                $scanLog->setIp(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

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

    public function getLastDeactivatedAt(): ?\DateTimeInterface
    {
        return $this->lastDeactivatedAt;
    }

    public function setLastDeactivatedAt(?\DateTimeInterface $lastDeactivatedAt): self
    {
        $this->lastDeactivatedAt = $lastDeactivatedAt;

        return $this;
    }
}
