<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Factura;
use App\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cliente',EntityType::class, [
                    'class' => Cliente::class,'choice_name'=>'nombre',
                ])
            ->add('detalles',EntityType::class, [
                'class' => Producto::class,'choice_name'=>'producto'])
            ->add('Guardar',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Factura::class,
        ]);
    }

}
