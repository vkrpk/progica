<?php

namespace App\Controller;

use App\Entity\Region;
use App\Entity\Service;
use App\Entity\Equipement;
use App\Entity\Departement;
use App\Repository\EquipementGiteRepository;
use App\Repository\EquipementRepository;
use App\Repository\GiteRepository;
use App\Repository\GiteServiceRepository;
use App\Repository\ServiceRepository;
use App\Repository\ViewEquipementGiteRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'label' => 'Equipements intérieurs',
                'attr' => [
                    'class' => 'select-equipement_interieur'
                ]
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
                'label' => 'Equipements extérieurs',
                'attr' => [
                    'class' => 'select-equipement_exterieur'
                ]
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
                'attr' => [
                    'class' => 'select-service'
                ]
            ])

            // ->add('valider', SubmitType::class, [
            //     'attr' => [
            //         'class' => 'send-container'
            //     ]
            // ])

            ->getForm();

        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/handleSearch', name:'handleSearch')]
    public function handleSearch(Request $request, GiteRepository $giteRepository, VilleRepository $villeRepository, ViewEquipementGiteRepository $ve, EquipementRepository $equipementRepository, ServiceRepository $serviceRepository)
    {
        $query = $request->request->all();
        if($query){
            if(!array_key_exists('equipement_exterieur', $query['form'])){
                $query['form']['equipement_exterieur'] = [];
            }
            if(!array_key_exists('equipement_interieur', $query['form'])){
                $query['form']['equipement_interieur'] = [];
            }
            if(!array_key_exists('service', $query['form'])){
                $query['form']['service'] = [];
            }
            $equipementArray = array_merge($query['form']['equipement_exterieur'], $query['form']['equipement_interieur']);

            $filtres = $this->findNomEquipements($equipementArray);

            $filtresEquipements = [];
            foreach ($equipementArray as $e) {
                $results = $equipementRepository->find($e);
                $nom = $results->getNom();
                $filtresEquipements[] = $nom;
            }

            $filtresServices = [];
            foreach ($query['form']['service'] as $e) {
                $results = $serviceRepository->find($e);
                $nom = $results->getNom();
                $filtresServices[] = $nom;
            }


            // $gites = $giteRepository->findByCriteres($equipementArray, $query['form']['service']);
            // dd($equipementArray);
            if(!empty($equipementArray) && empty($query['form']['service'])){
                $gites = $ve->findBy([
                    'equipement_id' => $equipementArray,
                ]);
            } elseif(!empty($query['form']['service']) && empty($equipementArray)){
                $gites = $ve->findBy([
                    'service_id' => $query['form']['service'],
                ]);
            } elseif(!empty($query['form']['service']) && !empty($equipementArray)){
                $gites = $ve->findBy([
                    'equipement_id' => $equipementArray,
                    'service_id' => $query['form']['service'],
                ]);
            }
            // $gites = $ve->findBy([
            //     'equipement_id' => $equipementArray,
            //     'service_id' => $query['form']['service'],
            // ]);
            $gitesArray = [];
            if(!empty($gites)){
                foreach ($gites as $gite) {
                    $gitesArray[] = $giteRepository->find($gite->getGiteId());
                }
            }
            if(empty($gitesArray)){
                $gitesArray = $giteRepository->findAll();
            }
            // foreach ($gitesArray as $gite) {
            //     dd($gite->getEquipementGites());
            // }
            return $this->render('search/index.html.twig', [
                'gites' => $gitesArray,
                'filtresEquipements' => $filtresEquipements,
                'filtresServices' => $filtresServices,
            ]);
        }
        return $this->render('search/index.html.twig');
    }

    public function villeById(int $id, VilleRepository $villeRepository)
    {
        $ville = $villeRepository->find($id);
        $ville = $ville->getNom();
        return new Response($ville);
    }

    public function equipementsArrayById(int $id, EquipementGiteRepository $equipementGiteRepository)
    {
        $equipements = $equipementGiteRepository->findAllByGite($id);
        $array = [];
        foreach ($equipements as $equipement) {
            $array[] = $equipement['nom'];
        }
        $arrayExplode = implode(', ', $array);
        return new Response($arrayExplode);
    }

    public function servicesArrayById(int $id, GiteServiceRepository $giteServiceRepository)
    {
        $services = $giteServiceRepository->findAllByGite($id);
        $array = [];
        foreach ($services as $service) {
            $array[] = $service['nom'];
        }
        $arrayExplode = implode(', ', $array);
        return new Response($arrayExplode);
    }

    public function findNomEquipements(array $array)
    {
        // $filtres = [];
        // foreach ($array as $a) {
        //     $results = $>find($a['id']);
        //     $filtres[] = $results;
        // }
        // dd($filtres);
    }
}
