<?php

namespace StructuredDocumentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StructuredDocumentBundle:Default:index.html.twig', array('name' => $name));
    }
}
