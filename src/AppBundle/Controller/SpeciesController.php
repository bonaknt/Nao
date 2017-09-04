<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Observations;

use AppBundle\Form\ObservationsType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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

		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Observations');

		$observations = $repository->findBySpecies($id);
		$pictures = $repository->findPicturesBySpecies($id);
		$numofpics = $repository->countPicturesBySpecies($id);

		return $this->render('nao/species/speciesCard.html.twig', array(
			'species' => $species, 'observations' => $observations, 'pictures' => $pictures, 'numofpics' => $numofpics
		));
	}

	/**
	 * @Route("/speciessearch", name="speciesSearch")
	 */
	public function speciesSearchAction(Request $request)
	{
		$repositorySpecies = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Species');

		$repositoryObs = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Observations');

		if($request->isMethod('GET') && $request->get('id') != null)
		{
			$id = $request->get('id');
			$specieName = $repositorySpecies->findSpeciesById($id);

			return $this->render('nao/species/speciesSearch.html.twig', array(
				'specieName' => $specieName,
			));
		}

		return $this->render('nao/species/speciesSearch.html.twig');
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
			//	Il faut ajouter un champ pour ajouter les images capturées
		$observationsForm = $this
			->get('form.factory')
			->create(ObservationsType::class, $observationsEntity)
			->add('species', ChoiceType::class, array(
				//	on inverse les clés et valeurs
				'choices'	=> array_flip($listScientificName),
				'label'		=> "Espèce d'oiseau rencontré",
				'attr'	=> ['class' => 'form-control'],
			));

		// Attraper la requete
		$observationsForm->handleRequest($request);

		if ($observationsForm->isSubmitted() && $observationsForm->isValid())
		{
			$picture = $observationsEntity->getPictures();
			// S'il y a une image
			if($picture != null)
			{
				//	Un nom unique pour le fichier :
				$pictureName = md5(uniqid()).'.'.$picture->guessExtension();
				//	Déplace le fichier dans la répertoire photo
				$picture->move(
					$this->getParameter('pictures_directory'),
					$pictureName
				);
				$observationsEntity->setPictures($pictureName);
			}

			$em = $this->getDoctrine()->getManager();
			$em->persist($observationsEntity->setIdUser(1));
			$em->persist($observationsEntity);
			$em->flush();
		}

		return $this->render('nao/species/addingSpecies.html.twig', [
			'observationsForm' 	=> $observationsForm->createView(),
		]);
	}

	/*

	 * @Route("/obswaitingvalidation", name="obsWaitingValidation")

	public function obsWaitingValidationAction(Request $request)
	{
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Observations');

		//	Trouver toutes les observations pas encore validées
		$listObservationsInvalid = $repository->findInvalid();

		//	Récupérer le nom des espèces des espèces pas encore validées au lieu des nombres.
		$listObsInvalidName = $repository->findObsInvalidSpecies();
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Species');

		//	On met dans un tableau le nom des espèces
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


	 * @Route("/obsvalidated", name="obsValidated")

	public function ObsValidatedAction(Request $request)
	{
		//	Récupérer l'id
		$id = $request->get('id');
		//	passer Validated à 1 dans MYSQL
		$em = $this->getDoctrine()->getManager();
		$valid = $em->getRepository(Observations::class)->findById($id);
		$valid->setValidated('1');
		$em->flush();

		return $this->redirectToRoute('obsWaitingValidation');
	}


	 * @Route("/obsdeleted", name="obsDeleted")

	public function ObsDeletedAction(Request $request)
	{
		//	Récupérer l'id
		$id = $request->get('id');
		//	Supprimer l'obj
		$em = $this->getDoctrine()->getManager();
		$valid = $em->getRepository(Observations::class)->findById($id);
		$em->remove($valid);
		$em->flush();

		return $this->redirectToRoute('obsWaitingValidation');
	}*/
}