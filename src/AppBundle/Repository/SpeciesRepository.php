<?php

namespace AppBundle\Repository;

/**
 * SpeciesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SpeciesRepository extends \Doctrine\ORM\EntityRepository
{
	public function findScientificName()
	{
		$query = $this->_em->createQuery('SELECT s FROM AppBundle:Species s');
		$results = $query->getResult();

		$scientificNameArray = [];
		foreach ($results as $scientificName) {
			array_push($scientificNameArray, $scientificName->getScientificName());
		}

		return $scientificNameArray;
	}
}
