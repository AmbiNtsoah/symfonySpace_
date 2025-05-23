<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Attribute\Route;

// final class PreferenceController extends AbstractController
// {
//     #[Route('/preference', name: 'app_preference')]
//     public function index(): Response
//     {
//         return $this->render('preference/index.html.twig', [
//             'controller_name' => 'PreferenceController',
//         ]);
//     }
// }

// src/Controller/PreferenceController.php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Preference;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/users/{id}/preferences')]
class PreferenceController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function getPreference(User $user): JsonResponse
    {
        $pref = $user->getPreference();

        return $this->json($pref);
    }

    #[Route('', methods: ['PUT'])]
    public function updatePreference(
        Request $request,
        User $user,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $pref = $user->getPreference() ?? new Preference();
        $pref->setLangue($data['langue']);
        $pref->setTheme($data['theme']);
        $pref->setNotification($data['notifications']);
        $pref->setUsers($user);

        $em->persist($pref);
        $em->flush();

        return $this->json($pref, 200);
    }
}
