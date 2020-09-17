<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductoRepository::class)
 */
class Producto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $producto;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $codigo;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $precio;
    /**
     * @ORM\Column(type="string", length=50,nullable=true)
     */
    private $foto;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detalle", mappedBy="producto")
     */
    private $detalles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducto(): ?string
    {
        return $this->producto;
    }

    public function setProducto(string $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param mixed $foto
     */
    public function setFoto($foto): void
    {
        $this->foto = $foto;
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
    public function __toString(){
        // to show the name of the Category in the select
        return $this->producto;
        // to show the id of the Category in the select
        // return $this->id;
    }

}
