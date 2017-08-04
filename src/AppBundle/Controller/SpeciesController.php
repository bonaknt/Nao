<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Observations;

use AppBundle\Form\ObservationsType;

class SpeciesController extends Controller
{

	/**
	 * @Route("/speciessearch", name="speciesSearch")
	 */
	public function speciesSearchAction(Request $request)
	{
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Species');

		$listSpecies = $repository->findAll();

		dump($listSpecies);

		return $this->render('nao/species/speciesSearch.html.twig', array(
			'listSpecies' => $listSpecies,
		));
	}

	/**
	 * @Route("/addingspecies", name="addingSpecies")
	 */
	public function addingSpeciesAction(Request $request)
	{
		$observationsEntity = new Observations();
		$observationsForm = $this
			->get('form.factory')
			->create(ObservationsType::class, $observationsEntity);

		return $this->render('nao/species/addingSpecies.html.twig', [
			'observationsForm' => $observationsForm->createView(),
		]);
	}

	/**
	 * @Route("/obswaitingsalidation", name="obsWaitingValidation")
	 */
	public function obsWaitingValidationAction(Request $request)
	{
		return $this->render('nao/species/obsWaitingValidation.html.twig');
	}
}
