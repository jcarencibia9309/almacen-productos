<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('upc')
            ->add('pesoGramos')
            ->add('pesoOnzas')
            ->add('pesoLibras')
            ->add('marca')
            ->add('descripcionEs')
            ->add('descripcionEn')
            ->add('foto', 'file', array(
                'data_class' => null,
                'label' => 'Imagen (JPEG)',
                'attr' => array('accept' => 'image/jpeg'),
                'required' => false
            ))
            ->add('fechaExpiracion')
            ->add('categoria', 'entity', array(
                'class' => 'AppBundle:Categoria',
                'placeholder' => 'Selecciona una categoría',
                'choice_label' => 'nombre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.activo = true')
                        ->orderBy('c.nombre', 'ASC');
                },
            ))
            ->add('activo');
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Producto'
        ));
    }
}
