<?php

namespace App\Controller;

use App\Entity\Factura;
use App\Form\FacturaType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
class FacturaController extends AbstractController
{
    /**
     * @Route("/crear_factura", name="CrearFactura")
     */
    public function index(Request $req)
    {
        $factura = new Factura();
        $formFactura = $this->createForm(FacturaType::class,$factura);
        $formFactura->handleRequest($req);
        if($formFactura->isSubmitted() && $formFactura->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $user = $this->getUser();
            $factura->setUsuario($user);
            $em->persist($factura);
            $em->flush();
            return $this->redirectToRoute('');
        }
        return $this->render('factura/index.html.twig', [
            'controller_name' => 'FacturaController',
            'formFactura'=>$formFactura->createView()
        ]);
    }
    /**
     * @Route("/listar-facturas/{id}", name="ListarFacturas")
     */
    public function listarFacturas(PaginatorInterface $paginator, Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        //$productos= $em->getRepository(Producto::class)->findAll();
        //$productos= $em->getRepository(Producto::class)->find(1);
        //$productos= $em->getRepository(Producto::class)->findBy(['producto'=>'Papas']);
        $query= $em->getRepository(Factura::class)->obtenerAllFacturas();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $req->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render('factura/listar-facturas.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    /**
     * @Route("/ver-factura/{id}", name="VerFactura")
     */
    public function VerFactura($id)
    {
        $em = $this->getDoctrine()->getManager();
        $factura= $em->getRepository(Factura::class)->find($id);
        return $this->render('factura/ver-factura.html.twig', [
            'factura'=>$factura
        ]);
    }
    /**
     * @Route("/mis-facturas", name="VerFactura")
     */
    public function MisFactura()
    {
        $em = $this->getDoctrine()->getManager();
        $facturas = $em->getRepository(Factura::class)->findBy(['usuario'=>$user]);

        return $this->render('factura/mis-facturas.html.twig', [
            'facturas'=>$facturas
        ]);
    }
}
