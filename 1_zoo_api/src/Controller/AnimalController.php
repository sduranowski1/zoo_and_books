<?php
namespace App\Controller;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Entity\Animals\Tiger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController {
    #[Route('/add-tiger', name: 'add_tiger')]
    public function addTiger(EntityManagerInterface $entityManager): Response {
        $tiger = new Tiger('Duke');
        $entityManager->persist($tiger);
        $entityManager->flush();

        return new Response("Dodano: " . $tiger);
    }
}
