<?php
/**
 * Created by PhpStorm.
 * User: Anas.Dawood
 * Date: 7/9/2018
 * Time: 2:08 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CityDetailType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class)
            ->add('temperature', TextType::class)
            ->add('humidity', TextType::class)
            ->add('icon', TextType::class)
            ->add('dashboard', DashboardType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\CityDetail',
            'allow_extra_fields' => true,
        ]);
    }

}