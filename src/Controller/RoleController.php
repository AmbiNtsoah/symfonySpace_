<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Attribute\Route;

// final class RoleController extends AbstractController
// {
//     #[Route('/role', name: 'app_role')]
//     public function index(): Response
//     {
//         return $this->render('role/index.html.twig', [
//             'controller_name' => 'RoleController',
//         ]);
//     }
// }

// src/Controller/RoleController.php
namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/roles')]
class RoleController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function list(RoleRepository $roleRepository): JsonResponse
    {
        return $this->json($roleRepository->findAll());
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $role = new Role();
        $role->setNom($data['nom']);

        $em->persist($role);
        $em->flush();

        return $this->json($role, 201);
    }
}
