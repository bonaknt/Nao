<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConnectionController extends Controller
{
	/**
	 * @Route("/login", name="login")
	 */
	public function loginAction(Request $request)
	{
		return $this->render('nao/connection/login.html.twig');
	}

	/**
	 * @Route("/signin", name="signin")
	 */
	public function signinAction(Request $request)
	{
		return $this->render('nao/connection/signin.html.twig');
	}

}
