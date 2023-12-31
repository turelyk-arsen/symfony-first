<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

// use Symfony\Component\HttpFoundation\JsonResponse;

class MoviesController extends AbstractController
{   
    private $em;
    private $movieRepository;
    public function __construct(EntityManagerInterface $em, MovieRepository $movieRepository) 
    {
        $this->em = $em;
        $this->movieRepository = $movieRepository;
    }

    #[Route('/', name: 'homepage')]
    public function ind(): Response
    {   
        $movies = $this->movieRepository->findAll();
        
        // dd($movies);
        return $this->render('/movies/index.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/movies', methods: ['GET'], name: 'movies')]
    public function index(): Response
    {   
        $movies = $this->movieRepository->findAll();
        
        // dd($movies);
        return $this->render('/movies/index.html.twig', [
            'movies' => $movies
        ]);

        // return $this->render('/movies/index.html.twig', [
        //     'movies' => $this->movieRepository->findAll()
        // ]);
    }

    // #[Route('/movies/create', name: 'create_movie')]
    // public function create (Request $request): Response {
        
    //     $movie = new Movie();
    //     $form = $this->createForm(MovieFormType::class, $movie);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $newMovie = $form->getData();
            
    //         dd($newMovie);
    //         exit;
    //     }
        
    //     return $this->render('/movies/create.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }


    #[Route('/movies/create', name: 'create_movie')]
    public function create(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();
            $imagePath = $form->get('imagePath')->getData();
            
            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                // $newMovie->setUserId($this->getUser()->getId());
                $newMovie->setImagePath('/uploads/' . $newFileName);
            }

            $this->em->persist($newMovie);
            $this->em->flush();

            return $this->redirectToRoute('movies');
        }

        return $this->render('movies/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/movies/edit/{id}', name: 'edit_movie')]
    public function edit($id, Request $request): Response 
    {
        // $this->checkLoggedInUser($id);
        $movie = $this->movieRepository->find($id);

        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        $imagePath = $form->get('imagePath')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($imagePath) {
                if ($movie->getImagePath() !== null) {
                    if (file_exists(
                        $this->getParameter('kernel.project_dir') . $movie->getImagePath()
                        )) {
                            $this->getParameter('kernel.project_dir') . $movie->getImagePath();
                    }
                    $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                    try {
                        $imagePath->move(
                            $this->getParameter('kernel.project_dir') . '/public/uploads',
                            $newFileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }

                    $movie->setImagePath('/uploads/' . $newFileName);
                    $this->em->flush();

                    return $this->redirectToRoute('movies');
                }
            } else {
                $movie->setTitle($form->get('title')->getData());
                $movie->setReleasedYear($form->get('releasedYear')->getData());
                $movie->setDescription($form->get('description')->getData());

                $this->em->flush();
                return $this->redirectToRoute('movies');
            }
        }

        return $this->render('movies/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()
        ]);
    }

    #[Route('/movies/delete/{id}', methods: ['GET', 'DELETE'], name: 'delete_movie')]
    public function delete($id): Response
    {
        // $this->checkLoggedInUser($id);
        $movie = $this->movieRepository->find($id);
        $this->em->remove($movie);
        $this->em->flush();

        return $this->redirectToRoute('movies');
    }

    #[Route('/movies/{id}', methods: ['GET'], name: 'app_movie')]
    public function show($id): Response
    {   
        $movie = $this->movieRepository->find($id);
        
        return $this->render('/movies/show.html.twig', [
            'movie' => $movie
        ]);
    }
    
    // #[Route('/movies/{name}', name: 'app_movies', defaults:['name'=>null], methods: ['GET', 'HEAD'])]
    // public function index($name): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller '.$name,
    //         'path' => 'src/Controller/MoviesController.php'
    //     ]);
    // }
    // private $em;
    // public function __construct(EntityManagerInterface $em)
    // {
    //     $this->em = $em;
    // }
    // #[Route('/movies', name: 'app_movies')]
    // public function index(MovieRepository $movieRepository): Response
    // {   
    //     $movies = $movieRepository->findAll();
    //     // dd($movies);
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
    

    // public function index (): Response
    // {   
        // $repository = $this->em->getRepository(Movie::class);
        // findAll() SELECT * FROM movies
        // $movies= $repository->findAll();
        
        // find() - SELECT * FROM movies WHERE id = 5
        // $movies= $repository->find('5');
        
        // findBy() - SELECT * FROM movies ORDER BY id DESC
        // $movies= $repository->findBy([],['id'=>'DESC']);

        //findOneBy - SELECT * FROM movies WHERE id = 5
        // AND title = 'The Dark Knight' ORDER BY id DESC
        // $movies= $repository->findOneBy(['id' => 5, 'title' => 'The Dark Knight'],
        // ['id'=>'DESC']);

        //count() - SELECT COUNT * FROM movies WHERE id = 5
        // $movies = $repository->count(['id'=> 5]);

        //App\Entity\Movie
        // $movies = $repository->getClassName();
        
        // dd($movies);
        // $movies = ["Avengers: Endgame", "Inception", "Loki", "Black Widow"];
        
        // return $this->render('index.html.twig', 
        // // ['title' => 'Avengers: Endgame']
        //  array('movies' => $movies)
        // );

    //     return $this->render('index.html.twig');
    // }
}