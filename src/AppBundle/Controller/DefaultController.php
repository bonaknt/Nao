<?php

namespace AppBundle\Controller;

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
    	if(isset($_COOKIE['id']) && isset($_COOKIE['pw']))
		{
			return $this->render('nao/indexConnected.html.twig');
		}

        return $this->render('nao/index.html.twig');
    }

}
