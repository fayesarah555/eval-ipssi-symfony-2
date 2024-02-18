<?php
namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('Contenu')
            ->add('etat') // Assuming 'etat' is a boolean field
            ->add('auteur', EntityType::class, [
                'class' => Utilisateur::class,
                'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                    // Customize the query to fetch only users with ROLE_EDITOR
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.roles LIKE :role')
                        ->setParameter('role', '%ROLE_EDITOR%');
                },
                'choice_label' => 'nom', // Use the 'nom' property as the display label
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'titre',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => \App\Entity\Article::class,
            'editors' => [], // Default value for the 'editors' option
        ]);
    }
}
