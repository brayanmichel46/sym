<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\ClienteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    /**
     * @Route("/registrar-cliente", name="RegistrarCliente")
     */
    public function index(Request $req)
    {
        $cliente = new Cliente();
        $formCliente = $this->createForm(ClienteType::class,$cliente);
        $formCliente->handleRequest($req);
        if($formCliente->isSubmitted() && $formCliente->isValid()){
            $brochureFile = $formCliente['foto']->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = 'cli';
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('clientes_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    throw new \Exception('UPS! ha ocurrido un error, sorry :C');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $cliente->setFoto($newFilename);
            }
            $em=$this->getDoctrine()->getManager();
            $em->persist($cliente);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('cliente/index.html.twig', [
            'controller_name' => 'ClienteController',
            'formCliente'=>$formCliente->createView()
        ]);
    }

}
