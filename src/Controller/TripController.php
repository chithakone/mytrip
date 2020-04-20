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
     * @Route("/trip/{id}", name="trip_show")
     */
    public function show(Trip $trip)
    { 
        return $this->render('trip/show.html.twig', [
            'trip' => $trip
        ]);
    }
}
