<?php

namespace App\Entity;

use App\Repository\DetalleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetalleRepository::class)
 */
class Detalle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Factura", inversedBy="detalles")
     */
    private $factura;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto", inversedBy="detalles")
     */
    private $producto;

    /**
     * @ORM\Column(type="smallint")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $vr_unitario;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $vr_total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactura(): ?int
    {
        return $this->factura;
    }

    public function setFactura(int $factura): self
    {
        $this->factura = $factura;

        return $this;
    }

    public function getProducto(): ?int
    {
        return $this->producto;
    }

    public function setProducto(int $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getVrUnitario(): ?string
    {
        return $this->vr_unitario;
    }

    public function setVrUnitario(string $vr_unitario): self
    {
        $this->vr_unitario = $vr_unitario;

        return $this;
    }

    public function getVrTotal(): ?string
    {
        return $this->vr_total;
    }

    public function setVrTotal(string $vr_total): self
    {
        $this->vr_total = $vr_total;

        return $this;
    }
}
