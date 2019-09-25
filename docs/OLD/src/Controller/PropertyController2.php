<?php
namespace App\Controller;


use App\Entity\Property;
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
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(): Response
    {

        /* Creer un Enregistrement

        # On instancie l'entite (Property)
        $property = new Property();

        # On remplit ses champs
        $property->setTitle('Mon premier bien') // titre
                 ->setPrice(200000) // prix
                 ->setRooms(4)     // nombre de pieces
                 ->setBedrooms(3)  // nombre de chambres
                 ->setDescription('Une petite description') // description
                 ->setSurface(60) // la surface 60 m2
                 ->setFloor(4)    // 4 ieme etage
                 ->setHeat(1)     // type de chauffage
                 ->setCity('Montpellier')    // Definit la ville
                 ->setAddress('15 Boulevard Gambetta') // Definit address
                 ->setPostalCode('34000');  // Definit code postal


        # Une fois remplit on va envoyer les donnees vers la base de donnees
        # Et de gerer leur persistence au sein de la BD
        # On obtient entity manager
        $em = $this->getDoctrine()->getManager();

        # Ensuite je lui dis j'aimerais que tu persites mon entite
        $em->persist($property);

        # Puis utiliser la methode flush
        # cette methode permet de porter tous les changements qui ont ete fait au niveau de Entity Manager
        $em->flush();

        */

        # Affiche la vue et on passes les differents parametres
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }


    private function creerUnEnregistrement()
    {
        /* Creer un Enregistrement

      # On instancie l'entite (Property)
      $property = new Property();

      # On remplit ses champs
      $property->setTitle('Mon premier bien') // titre
               ->setPrice(200000) // prix
               ->setRooms(4)     // nombre de pieces
               ->setBedrooms(3)  // nombre de chambres
               ->setDescription('Une petite description') // description
               ->setSurface(60) // la surface 60 m2
               ->setFloor(4)    // 4 ieme etage
               ->setHeat(1)     // type de chauffage
               ->setCity('Montpellier')    // Definit la ville
               ->setAddress('15 Boulevard Gambetta') // Definit address
               ->setPostalCode('34000');  // Definit code postal


      # Une fois remplit on va envoyer les donnees vers la base de donnees
      # Et de gerer leur persistence au sein de la BD
      # On obtient entity manager
      $em = $this->getDoctrine()->getManager();

      # Ensuite je lui dis j'aimerais que tu persites mon entite
      $em->persist($property);

      # Puis utiliser la methode flush
      # cette methode permet de porter tous les changements qui ont ete fait au niveau de Entity Manager
      $em->flush();

      */
    }
}