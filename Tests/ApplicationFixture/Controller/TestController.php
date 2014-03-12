<?php

namespace Jonlil\CKFinderBundle\Tests\ApplicationFixture\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function formAction()
    {
        $rich_text = new \stdClass;
        $rich_text->content = '';
        $form = $this->createFormBuilder($rich_text)
            ->add('content', 'ckfinder')
            ->getForm();
        return $this->render('::form.html.twig', array('form' => $form->createView()));
    }
}