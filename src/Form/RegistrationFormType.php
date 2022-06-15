<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, ["attr" => ["class" => "form-control","placeholder" => "Last name","autocomplete" => "off"]])
            ->add('firstname', TextType::class, ["attr" => ["class" => "form-control","placeholder" => "First name","autocomplete" => "off"]])
            ->add('email', EmailType::class, ["attr" => ["class" => "form-control","placeholder" => "E-mail","autocomplete" => "off"]])
            //->add('password')
            ->add('agreeTerms', CheckboxType::class, ['mapped' => false,'constraints' => [new IsTrue(['message' => 'You should agree to our terms.',]),],])

            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    "class" => "form-control",
                    "placeholder" => "Password",
                    "autocomplete" => "off"
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, ["required" => true])
            /* ->add("roles", ChoiceType::class, [
                "mapped" => true,
                /* "choice_label" => "name", *./
                "multiple" => true,
                'expanded' => false,
                'choice_value' => 'id',
                "choices" => [
                    "Admin" => "ROLE_ADMIN",
                    "User" => "ROLE_USER"
                ]
            ]) */
            ;
            /* ->add('roles', EntityType::class, [
                'class' => Roles::class,
                'mapped' => true,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'constraints' => array(
                    new \Symfony\Component\Validator\Constraints\Count(['min' => 1, 'minMessage' => 'Please select at least one role'])
                ),
                'choice_value' => 'id'
            ]); */
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
