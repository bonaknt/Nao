<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsefulLinkController extends Controller
{
	/**
	 * @Route("/contactus", name="contactUs")
	 */
	public function contactUsAction(Request $request)
	{

		$contactForm = $this->createFormBuilder()
			->add('name', TextType::class, array(
				'label'	=>	"Nom complet",
				'attr'	=>	['class'	=>	'form-control']
			))
			->add('obj', TextType::class, array(
				'label'	=>	"Objet",
				'attr'	=>	['class'	=>	'form-control']
			))
			->add('msg', TextareaType::class, array(
				'label'	=>	"Message",
				'attr'	=>	['class'	=>	'form-control', 'style'	=>	'resize:vertical; min-height:200px;']
			))
			->add('send', SubmitType::class, array(
				'label' => 'Envoyer',
				'attr'	=>	['class'	=>	'btn btn-primary']
			))
			->getForm();

		return $this->render('nao/usefulLinks/contactUs.html.twig', array(
			'contactForm'	=> $contactForm->createView(),
		));
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
