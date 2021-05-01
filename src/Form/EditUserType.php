<?php

namespace App\Form;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Controller\AdminController;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\EditUserType;
use App\Form\ChoiceType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
     $builder
        ->add('email')
        ->add('roles',ChoiceType::class,['choices' => ['Utilisateur' =>'ROLE_USER','Editeur'=>'ROLE_EDITOR',
        'Administrateur'=>'ROLE_ADMIN'],'expanded' => true,'multiple' => true,'label'=>'Rôles']);
       
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
   

}
