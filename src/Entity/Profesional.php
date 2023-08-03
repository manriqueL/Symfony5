<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Profesional
 *
 * @ORM\Table(name="profesional", indexes={@ORM\Index(name="fk_emid", columns={"empleado_id"})})
 * @ORM\Entity
 */
class Profesional
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
     * @ORM\Column(name="profesion", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $profesion = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="matricula", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $matricula = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fechaInicio", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $fechainicio = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fechaFin", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $fechafin = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $estado = 'NULL';

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
