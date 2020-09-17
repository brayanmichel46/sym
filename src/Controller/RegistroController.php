<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use phpDocumentor\Reflection\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $req, UserPasswordEncoderInterface $passwordEncoder)
    {

        $user = new User();
        $formUser = $this->createForm(UserType::class,$user);
        $formUser->handleRequest($req);
        if($formUser->isSubmitted() && $formUser->isValid()){
            //em persitir o guardar o eliminar
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($passwordEncoder->encodePassword($user,$formUser{'password'}->getData()));
            $em->persist($user);
            $em->flush();
            $this->addFlash('exito',User::REGISTRO_EXITOSO);
            return $this->redirectToRoute('registro');

        }
        return $this->render('registro/index.html.twig', [
            'controller_name' => 'Hola Mundo!',
            'miVariable' => 'Esta es mi variable',
            'formUser' => $formUser->createView()
        ]);
    }
}
