<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PropertyController
 * @package App\Controller
 */
class PropertyController1 extends AbstractController
{


     /**
      * @Route("/biens", name="property.index")
      * @return Response
     */
     public function index(): Response
     {
         return new Response('Les biens');
     }
}