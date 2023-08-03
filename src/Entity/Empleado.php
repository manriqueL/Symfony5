<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Empleado
 *
 * @ORM\Table(name="empleado")
 * @ORM\Entity
 */
class Empleado
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
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $nombre = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $apellido = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="dni", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $dni = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $direccion = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $telefono = 'NULL';


}
