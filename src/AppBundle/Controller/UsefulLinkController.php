<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UsefulLinkController extends Controller
{
	/**
	 * @Route("/contactus", name="contactUs")
	 */
	public function contactUsAction(Request $request)
	{
		//	Création du formulaire
		$contactForm = $this->createFormBuilder()
			->add('name', TextType::class, array(
				'label'	=>	"Nom complet",
				'attr'	=>	['class'	=>	'form-control']
			))
			->add('email', EmailType::class, array(
				'label'	=>	"Adresse Email",
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


		if ($request->isMethod('POST') && $contactForm->handleRequest($request)->isValid())
		{
			$message = \Swift_Message::newInstance();
			$message->setSubject($contactForm->getData()['obj']);
			$message->setFrom($contactForm->getData()['email']);
			$message->setTo($this->getParameter('mailer_user'));
			// pour envoyer le message en HTML
			$message->setBody(
				$contactForm->getData()['msg'],
				'text/html');
			//envoi du message
			$this->get('mailer')->send($message);

			$this->addFlash('success', 'Ok');
			$this->addFlash('sent', 'Ok');
		}

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
