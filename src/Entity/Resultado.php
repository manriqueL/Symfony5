<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultado
 *
 * @ORM\Table(name="resultado", indexes={@ORM\Index(name="fk_pid", columns={"profesional_id"}), @ORM\Index(name="fk_eid", columns={"examen_id"})})
 * @ORM\Entity
 */
class Resultado
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
     * @ORM\Column(name="informeResultado", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $informeresultado = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="estado", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $estado = 'NULL';

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
     * @var \Examen
     *
     * @ORM\ManyToOne(targetEntity="Examen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="examen_id", referencedColumnName="Id")
     * })
     */
    private $examen;

    /**
     * @var \Profesional
     *
     * @ORM\ManyToOne(targetEntity="Profesional")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profesional_id", referencedColumnName="Id")
     * })
     */
    private $profesional;

}
