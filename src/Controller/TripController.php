<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Trip;
use App\Form\TripType;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\TripRepository;

class TripController extends AbstractController
{
    /**
     * @Route("/trip", name="trip")
     */
    public function index(TripRepository $repo)
    {
        $trips = $repo->findAll();
        
        return $this->render('trip/index.html.twig', [
            'controller_name' => 'TripController',
            'trips' => $trips
        ]);
    }
    
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('trip/home.html.twig');
    }
    
    /**
     * @Route("trip/new", name="trip_create")
     * @Route("trip/{id}/edit", name="trip_edit")
     */
    public function form(Trip $trip = null, Request $request, EntityManagerInterface $manager)
    {
        
        if(!$trip){
            $trip = new Trip();
        }
        
        $form = $this->createForm(TripType::class, $trip);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            if(!$trip->getId()){
                $trip->setCreatedAt(new \DateTime());
            }
            
            $manager->persist($trip);
            $manager->flush();
            
            return $this->redirectToRoute('trip_show', ['id' => $trip->getId()]);
        }
        
        return $this->render('trip/create.html.twig', [
            'formTrip' => $form->createView(),
            'editMode' => $trip->getId() !== null
        ]);
    }
    
    /**
     * @Route("/trip/{id}", name="trip_show")
     * @return type
     */
    public function show(Trip $trip, Request $request, EntityManagerInterface $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime())
                    ->setTrip($trip);
            
            $manager->persist($comment);
            $manager->flush();
            
            return $this->redirectToRoute('trip_show', ['id' => $trip->getId()]);
        }
        
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
            'commentForm' => $form->createView(),
        ]);
    }
    

}
