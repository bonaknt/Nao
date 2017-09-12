<?php
/**
 * Created by PhpStorm.
 * User: TonyMalto
 * Date: 08/08/2017
 * Time: 20:07
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Species;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class ApiController extends Controller
{
    /**
     * @Route("/api/getallbirds", name="allbirds")
     */
    public function getSpeciesAction(Request $req)
    {
        if ($req->isXMLHTTPRequest())
        {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Species');

            $species = $repository->findAll();

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Observations');

            $observations = $repository->findAll();


            $response = new JsonResponse(array('species' => $species, 'observations' => $observations));
            return $response;
        }
        return new Response("Erreur, ceci n'est pas une requête ajax");
    }
}