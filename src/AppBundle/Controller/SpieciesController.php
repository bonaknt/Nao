<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SpieciesController extends Controller
{

	/**
	 * @Route("/speciesSearch", name="speciesSearch")
	 */
	public function speciesSearchAction(Request $request)
	{
		return $this->render('nao/species/speciesSearch.html.twig');
	}

	/**
	 * @Route("/addingSpecies", name="addingSpecies")
	 */
	public function addingSpeciesAction(Request $request)
	{
		return $this->render('nao/species/addingSpecies.html.twig');
	}

	/**
	 * @Route("/obsWaitingValidation", name="obsWaitingValidation")
	 */
	public function obsWaitingValidationAction(Request $request)
	{
		return $this->render('nao/species/obsWaitingValidation.html.twig');
	}
}
