<?php
namespace App\Controller;


use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PropertyController
 * @package App\Controller
 */
class PropertyController extends AbstractController
{


    /**
     * @var PropertyRepository
     */
    private $repository;


    /**
     * @var ObjectManager
     */
    private $em;


    /**
     * Autowiring  [ Dependency Injection ]
     * PropertyController constructor.
     * @param PropertyRepository $repository [ DIC ]
     * @param ObjectManager $em [ DIC ]
     */
     public function __construct(PropertyRepository $repository, ObjectManager $em)
     {
         $this->repository = $repository;
         $this->em = $em;
     }


    /**
     * @Route("/biens", name="property.index")
     * @param PaginatorInterface $paginator [ On peut injecter de la sorte et travailler avec ]
     * @param Request $request
     * @return Response
     */
     public function index(PaginatorInterface $paginator, Request $request): Response
     {
         # Creer une entite qui va representer notre recherche
         $search = new PropertySearch();

         # Creer un formulaire
         $form = $this->createForm(PropertySearchType::class, $search);
         $form->handleRequest($request);

         # Gerer le traitement dans le controller

         # Mise en place d'une pagination
         $properties = $paginator->paginate(
             $this->repository->findAllVisibleQuery($search), // retourne la requette
             $request->query->getInt('page', 1),
             12 // limit
         );

         # Affiche la vue et on passes les differents parametres
         return $this->render('property/index.html.twig', [
             'current_menu' => 'properties',
             'properties' => $properties,
             'form' => $form->createView()
         ]);
     }


     /*
      public function index(Request $request): Response
      {
         # Get all properties
         # $properties = $this->repository->findAllVisible();
         # getInt('page', 1) : 1 est la page par defaut, methode getInt() convertit la valeur du parametre en entier

         # https://github.com/KnpLabs/KnpPaginatorBundle
         $paginator = $paginator  = $this->get('knp_paginator');
         $properties = $paginator->paginate(
             $this->repository->findAllVisible(), // retourne la requette
             $request->query()->getInt('page', 1),
             12 // limit
         );

         # Affiche la vue et on passes les differents parametres
         return $this->render('property/index.html.twig', [
             'current_menu' => 'properties',
             'properties' => $properties
         ]);
     }
    */


     /*
     * @Route("/biens", name="property.index")
     * @param PaginatorInterface $paginator [ On peut injecter de la sorte et travailler avec ]
     * @param Request $request
     * @return Response
     public function index(PaginatorInterface $paginator, Request $request): Response
     {
        # Get all properties
        # $properties = $this->repository->findAllVisible();
        # getInt('page', 1) : 1 est la page par defaut, methode getInt() convertit la valeur du parametre en entier

        # https://github.com/KnpLabs/KnpPaginatorBundle
        # if(!is_null($paginator)) { $paginator  = $this->get('knp_paginator'); }
        $properties = $paginator->paginate(
            $this->repository->findAllVisible(), // retourne la requette
            $request->query()->getInt('page', 1),
            12 // limit
        );

        # Affiche la vue et on passes les differents parametres
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties
        ]);
      }
      */


    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property
     * @param string $slug
     * @return Response
     * NB (requirements permettent d'indiquer a quoi doit ressembler les differents parametres
     */
    public function show(Property $property, string $slug): Response
    {
        // Important pour le referenceent
        # si le slug est different de celui passe en parametre
        if($property->getSlug() != $slug)
        {
            # alors on redirige l'utilisateur vers une route
            # en symfony on peut rediriger vers une Route ou une URL
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }


    /*
    1 er cas
    public function show($slug, $id): Response
    {
        # Obtenir une propriete par son identifiant 'id'
        $property = $this->repository->find($id);

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }

    public function test(): Response
    {
        # Recuperer mon premier enregistrement (property)
        $property = $this->repository->find(1);
        dump($property);

        # Recuperer l'ensemble de tous mes biens [ Tableau de l'ensemble des biens ]
        $properties = $this->repository->findAll();
        dump($properties);


        # Recuperer les biens en passant des criteres
        # par exemple recuperer tous ceux qui sont au 4 -ieme etage
        $property = $this->repository->findOneBy(['floor' => 4]);
        dump($property);

        # Recuperer tous les biens qui ont solde a 'false' : (solde = false)
        $property = $this->repository->findAllVisible();


        die;
    }
    */
}