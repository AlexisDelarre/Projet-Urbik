<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $ip = $_SERVER['REMOTE_ADDR'];

        $builder
            ->add('email', EmailType::class)
            ->add('name', TextType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'disabled'=> true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('last_name', TextType::class)
            ->add('birthday', BirthdayType::class,  array(
                'widget' => 'single_text',

                'format' => 'yyyy-MM-dd'))

            ->add("country",TextType::class)
            ->add("depart",TextType::class)

            ->add('sexe',ChoiceType::class, array('choices'  => array( "Femme" => "Femme", "Homme " => "Homme",)))

            ->add("metier", ChoiceType::class, array('choices' => array(
                "Alternant" => "Alternant",
                "Cadre" => "Cadre",
                "Chef d'entreprise" => "Chef d'entreprise",
                "Etudiant" => "Etudiant",
                "Fonctionnaire" => "Fonctionnaire",
                "Ouvrier" => "Ouvrier",
                "Technicien" => "Technicien",
                "Sans Emploi" => "Sans Emploi",

            )))

            //->add('register', SubmitType::class,['label' => 'Register'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}
