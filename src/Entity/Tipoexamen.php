<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipoexamen
 *
 * @ORM\Table(name="tipoexamen")
 * @ORM\Entity
 */
class Tipoexamen
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $nombre = 'NULL';

}
