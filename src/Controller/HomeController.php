<?php
namespace App\Controller;


use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;



/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param PropertyRepository $repository
     * @return Response
     */
     public function index(PropertyRepository $repository): Response
     {
         # Recuperer les derniers biens
         $properties = $repository->findLatest();

         /* dump($properties); */

         # Render Home page
         return $this->render('pages/home.html.twig', [
             'properties' => $properties
         ]);
     }

}