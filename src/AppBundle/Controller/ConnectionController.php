<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConnectionController extends Controller
{
	/**
	 * @Route("/loin", name="login")
	 */
	public function loginAction(Request $request)
	{
	}

	/**
	 * @Route("/signin", name="signin")
	 */
	public function signinAction(Request $request)
	{
		return $this->render('nao/connection/signin.html.twig');
	}

}
