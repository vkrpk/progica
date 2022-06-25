<?php

namespace App\Controller;

use App\Entity\Region;
use App\Entity\Service;
use App\Entity\Equipement;
use App\Entity\Departement;
use App\Repository\GiteRepository;
use Doctrine\ORM\EntityRepository;
use App\Repository\RegionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'nom',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.nom', 'ASC');
                },
                'label' => 'Départements'
            ])

            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nom',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('r')
                    ->orderBy('r.nom', 'ASC');
                },
                'label' => 'Régions'
            ])

            ->add('equipement_interieur', EntityType::class, [
                'class' => Equipement::class,
                'multiple' => true,
                'choice_label' => 'nom',
                'required' => false,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('e')
                    ->where('e.isInterieur = 1')
                    ->orderBy('e.nom', 'ASC');
                },
                'label' => 'Equipements intérieurs'
            ])

            ->add('equipement_exterieur', EntityType::class, [
                'class' => Equipement::class,
                'multiple' => true,
                'choice_label' => 'nom',
                'required' => false,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('e')
                    ->where('e.isInterieur = 0')
                    ->orderBy('e.nom', 'ASC');
                },
                'label' => 'Equipements extérieurs'
            ])

            ->add('service', EntityType::class, [
                'class' => Service::class,
                'multiple' => true,
                'choice_label' => 'nom',
                'required' => false,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('s')
                    ->orderBy('s.nom', 'ASC');
                },
                'label' => 'Services',
                'compound' => false
            ])

            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])

            ->getForm();

        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/handleSearch', name:'handleSearch')]
    public function handleSearch(Request $request, GiteRepository $giteRepository)
    {
        $query = $request->request->all();
        // dd($query);
        if($query){
            $regions = $giteRepository->findByCriteres($query['form']['equipement_exterieur'], $query['form']['service']);
        }

        return $this->render('search/index.html.twig', [
            'gites' => $regions
        ]);
    }
}
