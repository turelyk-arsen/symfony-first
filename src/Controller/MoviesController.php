<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\JsonResponse;

class MoviesController extends AbstractController
{
    // #[Route('/movies/{name}', name: 'app_movies', defaults:['name'=>null], methods: ['GET', 'HEAD'])]
    // public function index($name): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller '.$name,
    //         'path' => 'src/Controller/MoviesController.php'
    //     ]);
    // }
    #[Route('/movies', name: 'app_movies')]
    public function index(): Response
    {   
        $movies = ["Avengers: Endgame", "Inception", "Loki", "Black Widow"];
        
        return $this->render('index.html.twig', 
        // ['title' => 'Avengers: Endgame']
         array('movies' => $movies)
        );
    }
}