<?php

namespace Uts\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'UtsContentBundle:Default:index.html.twig'
        );
    }

    public function prepareAction()
    {
        return $this->render(
            'UtsContentBundle:Default:prepare.html.twig'
        );
    }

    public function taskAction()
    {
        return $this->render(
            'UtsContentBundle:Default:task.html.twig'
        );
    }

    public function resultAction()
    {
        return $this->render(
            'UtsContentBundle:Default:result.html.twig'
        );
    }
}
