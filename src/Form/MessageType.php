<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MessageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Imię',
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nazwisko',
                'required' => false,
            ])
            ->add('attachment', FileType::class, [
                'label' => 'Załącznik',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/svg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Akceptowane formaty to JPEG, JPG, PNG, GIF, SVG.',
                        'maxSizeMessage' => 'Maksymalny rozmiar obrazka 2 MB',
                    ])
                ]
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Wyślij'
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
