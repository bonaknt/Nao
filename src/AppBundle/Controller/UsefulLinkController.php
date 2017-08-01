<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UsefulLinkController extends Controller
{
	/**
	 * @Route("/contactus", name="contactUs")
	 */
	public function contactUsAction(Request $request)
	{
		return $this->render('nao/usefulLinks/contactUs.html.twig');
	}

	/**
	 * @Route("/joinassoc", name="joinAssoc")
	 */
	public function joinAssocAction(Request $request)
	{
		return $this->render('nao/usefulLinks/joinAssoc.html.twig');
	}

	/**
	 * @Route("/legalnotice", name="legalNotice")
	 */
	public function legalNoticeAction(Request $request)
	{
		return $this->render('nao/usefulLinks/legalNotice.html.twig');
	}
}
