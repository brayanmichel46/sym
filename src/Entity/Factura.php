<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturaRepository::class)
 */
class Factura
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $fec_factura;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="facturas")
     */
    private $cliente;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $total;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="facturas")
     */
    private $usuario;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detalle", mappedBy="factura")
     */
    private $detalles;

    /**
     * Factura constructor.
     */
    public function __construct()
    {
        $this->fec_factura=new \DateTime();
        $this->total = 100;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecFactura(): ?\DateTimeInterface
    {
        $this->fec_factura;

    }

    public function setFecFactura(\DateTimeInterface $fec_factura): self
    {
        $this->fec_factura = $fec_factura;
        return $this;
    }

    public function getCliente(): ?int
    {
        return $this->cliente;
    }

    public function setCliente(int $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * @param mixed $detalles
     */
    public function setDetalles($detalles): void
    {
        $this->detalles = $detalles;
    }


}
