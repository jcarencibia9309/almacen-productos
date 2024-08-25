<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaVenta')
            ->add('almacenOrigen', 'entity', array(
                'class' => 'AppBundle:Almacen',
                'placeholder' => 'Selecciona un almacén',
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->andWhere('a.activo = true')
                        ->orderBy('a.nombre', 'ASC');
                },
            ))
            ->add('save', 'submit', array('attr' => array('class' => 'd-none')))
            ->add('complete', 'submit', array('attr' => array('class' => 'd-none')));
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Venta'
        ));
    }
}
