<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_dashboard', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        // Fetch users sorted by first name
        $users = $userRepository->findAllSortedByFirstName();
        return $this->render('admin/dashboard.html.twig', [
            'users' => $users,
        ]);
    }



    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
       

        if ($form->isSubmitted() && $form->isValid()) {
            
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('app_user_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('//{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_dashboard', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/Dashboard', name: 'app_dashboard_index', methods: ['GET'])]
    public function Client(UserRepository $userRepository): Response
    {
        return $this->render('user/dashboard.html.twig');
    }

    #[Route('/user/search', name: 'app_user_search')]
     public function searchuser (Request $request,UserRepository $userRepository): Response
    {
        $searchTerm = $request->query->get('q');
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->createQueryBuilder('p')
            ->where('p.firstname LIKE :term')
            ->orwhere('p.lastname LIKE :term')
            ->orwhere('p.email LIKE :term')
            ->setParameter('term', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();
        

        // Passer les produits filtrés au template Twig
        return $this->render('admin/dashboard.html.twig', [
            'users' => $user,
            'searchTerm' => $searchTerm
        ]);
    }

}
