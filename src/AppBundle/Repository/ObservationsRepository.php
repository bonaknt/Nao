<?php

namespace AppBundle\Repository;

/**
 * ObservationsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObservationsRepository extends \Doctrine\ORM\EntityRepository
{
	public function findInvalid()
	{
		$query  = $this->_em->createQuery('SELECT o FROM AppBundle:Observations o WHERE o.validated = 0');
		$results = $query->getResult();

		return $results;
	}
}
