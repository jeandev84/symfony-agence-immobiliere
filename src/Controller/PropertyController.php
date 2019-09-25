<?php
namespace App\Controller;


use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @return Response
     */
     public function index(): Response
     {
         # Affiche la vue et on passes les differents parametres
         return $this->render('property/index.html.twig', [
             'current_menu' => 'properties'
         ]);
     }


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