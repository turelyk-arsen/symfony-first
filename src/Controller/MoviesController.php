<?php

namespace App\Controller;

// use App\Repository\MovieRepository;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/movies', name: 'app_movies')]
    // public function index(MovieRepository $movieRepository): Response
    // {   
    //     $movies = $movieRepository->findAll();
    //     dd($movies);
    //     // $movies = ["Avengers: Endgame", "Inception", "Loki", "Black Widow"];
        
    //     // return $this->render('index.html.twig', 
    //     // // ['title' => 'Avengers: Endgame']
    //     //  array('movies' => $movies)
    //     // );

    //     return $this->render('index.html.twig');
    // }

    // public function second (EntityManagerInterface $emt): Response
    // {   
    //     $repository = $emt->getRepository(Movie::class);
    //     $movies= $repository->findAll();
    //     dd($movies);
    //     // $movies = ["Avengers: Endgame", "Inception", "Loki", "Black Widow"];
        
    //     // return $this->render('index.html.twig', 
    //     // // ['title' => 'Avengers: Endgame']
    //     //  array('movies' => $movies)
    //     // );

    //     return $this->render('index.html.twig');
    // }
    

    public function index (): Response
    {   
        $repository = $this->em->getRepository(Movie::class);
        // findAll() SELECT * FROM movies
        // $movies= $repository->findAll();
        
        // find() - SELECT * FROM movies WHERE id = 5
        // $movies= $repository->find('5');
        
        // findBy() - SELECT * FROM movies ORDER BY id DESC
        $movies= $repository->findBy([],['id'=>'DESC']);

        //findOneBy - SELECT * FROM movies WHERE id = 5
        // AND title = 'The Dark Knight' ORDER BY id DESC
        // $movies= $repository->findOneBy(['id' => 5, 'title' => 'The Dark Knight'],
        // ['id'=>'DESC']);

        //count() - SELECT COUNT * FROM movies WHERE id = 5
        // $movies = $repository->count(['id'=> 5]);

        //App\Entity\Movie
        // $movies = $repository->getClassName();
        
        dd($movies);
        // $movies = ["Avengers: Endgame", "Inception", "Loki", "Black Widow"];
        
        // return $this->render('index.html.twig', 
        // // ['title' => 'Avengers: Endgame']
        //  array('movies' => $movies)
        // );

        return $this->render('index.html.twig');
    }
}