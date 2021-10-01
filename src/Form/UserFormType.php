<?php


namespace App\Form;


use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->translator = $options['translator'];

        $builder
            ->add("username", TextType::class, [
                "label" => "Usuario"
            ])
            ->add("email", EmailType::class)
            ->add("nombre", TextType::class, [
                "label" => "Nombre",
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "El campo no puede estar vacío"])
                ]
            ])
            ->add("apellido", TextType::class, [
                "label" => "Apellido",
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "El campo no puede estar vacío"])
                ]
            ])
            ->add("dni", null, [
                "label" => "DNI",
                "required" => false,
            ])
            ->add("cuil", TextType::class, [
                "label" => "CUIL",
                "required" => false,
            ])
            ->add("telefono", TextType::class, [
                "label" => "Teléfono",
                "required" => false,
            ])
            ->add("direccion", TextType::class, [
                "label" => "Dirección",
                "required" => false,
            ])
            ->add("justpassword", TextType::class, [
                "label" => $this->translator->trans('backend.user.password'),
                "required" => true,
                "mapped" => false,
                "constraints" => [
                    new NotBlank(["message" => "El campo no puede estar vacío"])
                ]
            ])
            ->add("role", EntityType::class, [
                "mapped" => false,
                "class" => Role::class,
                "required" => true,
                "placeholder" => $this->translator->trans('backend.role.choice_role'),
                "constraints" => [
                    new NotBlank(["message" => "El campo no puede estar vacío"])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('translator');
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
