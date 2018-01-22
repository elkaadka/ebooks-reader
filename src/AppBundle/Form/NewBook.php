<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewBook extends AbstractType
{
    const FILE = 'book';
    const TITLE = 'book_title';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('post')
            ->add(
                self::FILE,
                FileType::class,
                [
                    'constraints' => [
                        new File([
                            'mimeTypes' => [
                                'application/pdf',
                                'application/x-pdf',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid PDF',
                        ])
                    ]
                ]
            )
            ->add(
                self::TITLE,
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 2])
                    ],

                ]
            );
    }

}