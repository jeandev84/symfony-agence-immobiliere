<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;



/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController
{

    /**
     * @var Environment $twig
     */
    private $twig;


    /**
     * [ Dependency Injection ]
     * HomeController constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @Route("/", name="home")
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(): Response
    {
        /*  return new Response('Salut les gens'); */
        return new Response($this->twig->render('pages/home.html.twig'));
    }
}