<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $document = new Document();
        $form = $this->createFormBuilder($document)
            ->add('name', 'text', array(
                'required' => false,
                'attr' => array(
                    'novalidate' => 'novalidate'
                )
            ))
            ->add('file', 'file', array(
                'required' => false,
                'attr' => array(
                    'novalidate' => 'novalidate'
                )
            ))
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($document);
            $em->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('default/index.html.twig', array('form' => $form->createView()));
    }
}
