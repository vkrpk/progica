<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->setAction($this->generateUrl('contact'))
            ->add('fullname', TextType::class, [
                'attr' => [
                    'class' => '',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Nom / Prénom',
                'label_attr' => [
                    'class' => ''
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => '',
                    'minlength' => '2',
                    'maxlength' => '180',
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180]),
                ]
            ])
            ->add('subject', TextType::class, [
                'attr' => [
                    'class' => '',
                    'minlength' => '2',
                    'maxlength' => '200',
                ],
                'label' => 'Sujet',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 100]),
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => '',
                ],
                'label' => 'Message',
                'label_attr' => [
                    'class' => ''
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'contact',
            ])
            // ->add('valider', SubmitType::class, [
            //     'attr' => [
            //         'class' => 'send-container'
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
