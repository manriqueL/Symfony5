<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Examen
 *
 * @ORM\Table(name="examen", indexes={@ORM\Index(name="fk_tex", columns={"tipoExamen_id"}), @ORM\Index(name="fk_esm", columns={"estudioMedico_id"})})
 * @ORM\Entity
 */
class Examen
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
     * @ORM\Column(name="archivo", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $archivo = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_At", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $updatedAt = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_At", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $createdAt = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="informeExamen", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $informeexamen = 'NULL';

    /**
     * @var \Estudiomedico
     *
     * @ORM\ManyToOne(targetEntity="Estudiomedico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estudioMedico_id", referencedColumnName="Id")
     * })
     */
    private $estudiomedico;

    /**
     * @var \Tipoexamen
     *
     * @ORM\ManyToOne(targetEntity="Tipoexamen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoExamen_id", referencedColumnName="id")
     * })
     */
    private $tipoexamen;


}
