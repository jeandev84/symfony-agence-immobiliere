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
        # Recuperer tous les biens qui ont solde a 'false' : (solde = false)
        $property = $this->repository->findAllVisible();
        dump($property);
        if(isset($property[0]))
        {
            $property[0]->setSold(true);
        }

        # Persist et Flush directement
        $this->em->flush();

        # Affiche la vue et on passes les differents parametres
        return $this->render('property/index.html.twig', [
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

        die;
    }

}