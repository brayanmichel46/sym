<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class ProductoController extends AbstractController
{
    /**
     * @Route("/registrar-producto", name="RegistrarProducto")
     */
    public function index(Request $req)
    {
        $producto = new Producto();
        $formProducto = $this->createForm(ProductoType::class,$producto);
        $formProducto->handleRequest($req);
        if($formProducto->isSubmitted() && $formProducto->isValid()){
            $brochureFile = $formProducto['foto']->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = 'pro';
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('productos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    throw new \Exception('UPS! ha ocurrido un error, sorry :C');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $producto->setFoto($newFilename);
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('producto/index.html.twig', [
            'controller_name' => 'ProductoController',
            'formProducto' => $formProducto->createView()
        ]);
    }
    /**
     * @Route("/listar-productos", name="listarProductos")
     */
    public function listarProductos(PaginatorInterface $paginator, Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        //$productos= $em->getRepository(Producto::class)->findAll();
        //$productos= $em->getRepository(Producto::class)->find(1);
        //$productos= $em->getRepository(Producto::class)->findBy(['producto'=>'Papas']);
        $query= $em->getRepository(Producto::class)->obtenerAllProductos();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $req->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render('producto/listar-productos.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    /**
     * @Route("/ver-producto/{id}", name="VerProducto")
     */
    public function verProducto($id)
    {
        $em = $this->getDoctrine()->getManager();
        $producto= $em->getRepository(Producto::class)->find($id);
        return $this->render('producto/ver-producto.html.twig', [
            'producto'=>$producto
        ]);
    }
    /**
     * @Route("/edit-producto/{id}", name="EditProducto")
     */
    public function editProducto(Request $req, Producto $producto)
    {
        $formProducto = $this->createForm(ProductoType::class,$producto);
        $formProducto->handleRequest($req);
        if($formProducto->isSubmitted() && $formProducto->isValid()){
            $brochureFile = $formProducto['foto']->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = 'pro';
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('productos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    throw new \Exception('UPS! ha ocurrido un error, sorry :C');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $producto->setFoto($newFilename);
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('producto/edit_producto.html.twig', [
            'controller_name' => 'ProductoController',
            'formProducto' => $formProducto->createView()
        ]);
    }
    /**
     * @Route("/delete-producto/{id}", name="DeleteProducto")
     */
    public function deleteProducto(Request $req, Producto $producto)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($producto);
        $em->flush();
        return $this->redirectToRoute('dashboard');
    }
    /**
     * @Route("/eliminar/{id}",options={"expose"=true},name="Eliminar")
     */
    public function eliminar(Request $req)
    {
        if($req->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $id=$req->get('id');
            $producto= $em->getRepository(ProductoType::class)->find($id);
            $em->remove($producto);
            $em->flush();
            return new JsonResponse(['respuesta'=>'Se eliminio esta vaina']);
        }else{

        }
        $em = $this->getDoctrine()->getManager();

        return $this->redirectToRoute('dashboard');
    }
}
