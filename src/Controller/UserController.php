<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\EnchereRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;



#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_dashboard', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

/**
     * @throws ConfigurationException
     * @throws TwilioException
*/
   private function sendTwilioMessage(User $user): void
    {
        $twilioAccountSid = $this->getParameter('twilio_account_sid');
        $twilioAuthToken = $this->getParameter('twilio_auth_token');
        $twilioPhoneNumber = $this->getParameter('twilio_phone_number');

        $twilioClient = new Client($twilioAccountSid, $twilioAuthToken);

        $messageBody = sprintf(
            'Your affectation has been successfully registered with the following details:' .
            "\nFirstname: %s\nLastname: %s\nEmail: %s\nAddress: %s",
            $user->getFirstname(),
            $user->getLastname(),
            $user->getEmail(),
            $user->getAddress(),
        );

        $twilioClient->messages->create(

           '+21653202496', // Replace with the recipient's phone number
            [
                'from' => $twilioPhoneNumber,
                'body' => $messageBody
            ]
        );
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
            $this->sendTwilioMessage($user);

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

    #[Route('/userEnchere', name: 'app_user')]
    public function displaybids(EnchereRepository $enchereRepository, PanierRepository $panierRepository): Response
    {
        // Fetch specific attributes from the repository
        $enchereData = $enchereRepository->findAllSpecificAttributes(); // Implement this method in EnchereRepository
        $cartItems = $panierRepository->getPanierWithProduit();
        $numberOfItems = count($cartItems);
        // Render the Twig template and pass the data
        return $this->render('user/afficheEnchere.html.twig', [
            'enchereData' => $enchereData,
            'numberOfItems' => $numberOfItems, // Passing fetched data to the template
        ]);
    }
}
