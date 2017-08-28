<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Observations;

use AppBundle\Form\ObservationsType;

class SpeciesController extends Controller
{

    /**
     * @Route("/speciessearch/{id}", name="speciesSearchId")
     */
    public function individualSpeciesSearchAction(Request $request, $id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Species');

        $species = $repository->find($id);

        return $this->render('nao/species/speciesCard.html.twig', array(
            'species' => $species,
        ));
    }

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

		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Species');

		$listScientificName = $repository->findScientificName();

		// Création du formulaire
		$observationsForm = $this
			->get('form.factory')
			->create(ObservationsType::class, $observationsEntity)
			->add('species', ChoiceType::class, array(
				//	on inverse les clés et valeurs
				'choices'	=> array_flip($listScientificName),
				'label'		=> "Espèce d'oiseau rencontré",
				'attr'	=> ['class' => 'form-control'],
			));

		// If form submit
		if ($request->isMethod('POST') && $observationsForm->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($observationsEntity->setIdUser(1));
			$em->persist($observationsEntity->setPictures("https://laughingsquid.com/wp-content/uploads/2013/11/Dird-schnauzer-640x514.png"));
			$em->persist($observationsEntity);
			$em->flush();
		}

				return $this->render('nao/species/addingSpecies.html.twig', [
			'observationsForm' 	=> $observationsForm->createView(),
		]);
	}

	/**
	 * @Route("/obswaitingvalidation", name="obsWaitingValidation")
	 */
	public function obsWaitingValidationAction(Request $request)
	{
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Observations');

		$listObservationsInvalid = $repository->findInvalid();

		$listObsInvalidName = $repository->findObsInvalidSpecies();
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Species');

		$listSpeciesName = [];

		for($i=0 ; $i<count($listObsInvalidName); $i++)
		{
			array_push($listSpeciesName, $repository->findSpeciesById($listObsInvalidName[$i]['species']));
		}

		return $this->render('nao/species/obsWaitingValidation.html.twig', array(
			'listObservationsInvalid' 	=> 	$listObservationsInvalid,
			'listSpeciesName'			=>	$listSpeciesName,
		));
	}
}
