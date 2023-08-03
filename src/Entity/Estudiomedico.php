<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Estudiomedico
 *
 * @ORM\Table(name="estudiomedico", indexes={@ORM\Index(name="fk_emp", columns={"empleado_id"})})
 * @ORM\Entity
 */
class Estudiomedico
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="informeEstudio", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $informeestudio = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_At", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $createdAt = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_At", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $updatedAt = 'NULL';

    /**
     * @var \Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empleado_id", referencedColumnName="Id")
     * })
     */
    private $empleado;


}
