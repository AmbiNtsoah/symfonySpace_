<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Attribute\Route;

// final class UserController extends AbstractController
// {
//     #[Route('/user', name: 'app_user')]
//     public function index(): Response
//     {
//         return $this->render('user/index.html.twig', [
//             'controller_name' => 'UserController',
//         ]);
//     }
// }

// src/Controller/UserController.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/users')]
class UserController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function list(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();
        return $this->json($users, 200, [], ['groups' => 'user:read']);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function detail(User $user): JsonResponse
    {
        return $this->json($user, 200, [], ['groups' => 'user:read']);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        RoleRepository $roleRepo
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setCreatedAt(new \DateTimeImmutable());

        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Ajouter les rôles
        foreach ($data['roles'] ?? [] as $roleName) {
            $role = $roleRepo->findOneBy(['nom' => $roleName]);
            if ($role) {
                $user->addRole($role);
            }
        }

        $em->persist($user);
        $em->flush();

        return $this->json($user, 201, [], ['groups' => 'user:read']);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        Request $request,
        User $user,
        EntityManagerInterface $em,
        RoleRepository $roleRepo
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $user->setEmail($data['email'] ?? $user->getEmail());
        $user->setNom($data['nom'] ?? $user->getNom());
        $user->setPrenom($data['prenom'] ?? $user->getPrenom());

        // Mettre à jour les rôles
        if (isset($data['roles'])) {
            $user->getRoles()->clear();
            foreach ($data['roles'] as $roleName) {
                $role = $roleRepo->findOneBy(['nom' => $roleName]);
                if ($role) {
                    $user->addRole($role);
                }
            }
        }

        $em->flush();

        return $this->json($user, 200, [], ['groups' => 'user:read']);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(User $user, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($user);
        $em->flush();

        return new JsonResponse(null, 204);
    }
}
