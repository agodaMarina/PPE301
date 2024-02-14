<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Repository\UtilisateurRepository;
use App\Security\UtilisateurAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register',methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UtilisateurAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/ajoutUtilisateur.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/view/{id}', name:'profile_utilisateur',methods: ['GET'])]
    public function VoirProfile(Utilisateur $utilisateur){
        
        return $this->render('security/profile.html.twig', [
            'user'=>$utilisateur
        ]);


    }

    #[Route('/read', name:'liste_utilisateur',methods: ['GET'])]
    public function ListeUser(UtilisateurRepository $userRepository){
        
        return $this->render('registration/listeUtilisateur.html.twig', [
            'users'=>$userRepository->findAll()
        ]);

    }
    #[Route('/delete/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $user, UtilisateurRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $this->container->get('security.token_storage')->setToken(null);
            $userRepository->remove($user, true);
        }
        $this->addFlash('deleted','Votre compte a été supprimé.');
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
