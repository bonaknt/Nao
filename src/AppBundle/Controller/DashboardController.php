<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
	/**
	 * @Route("/dashboard", name="dashboard")
	 */
	public function speciesSearchAction(Request $request)
	{
		return $this->render('nao/dashboard/dashboard.html.twig');
	}
}
