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

	public function findObsInvalidSpecies()
	{
		$query  = $this->_em->createQuery('SELECT o.species FROM AppBundle:Observations o WHERE o.validated = 0');
		$results = $query->getResult();

		return $results;
	}

	public function findById($id)
	{
		$query = $this->_em->createQuery('SELECT o FROM AppBundle:Observations o WHERE o.id = :id');
		$query->setParameter('id', $id);

		return $query->getSingleResult();
	}

	public function findBySpecies($species)
	{
		$query  = $this->_em->createQuery('SELECT o FROM AppBundle:Observations o WHERE o.species = :species');
		$query->setParameter('species', $species);

		$results = $query->getResult();

		return $results;
	}

	public function findPicturesBySpecies($species)
    {

        $query  = $this->_em->createQuery('SELECT o.pictures FROM AppBundle:Observations o WHERE o.species = :species');
        $query->setParameter('species', $species);

        $results = $query->getScalarResult();

        return $results;
    }

    public function countPicturesBySpecies($species)
    {

        $query  = $this->_em->createQuery('SELECT  COUNT(o.pictures) FROM AppBundle:Observations o WHERE o.species = :species');
        $query->setParameter('species', $species);

        $results = $query->getScalarResult();

        return $results;
    }

    public function findLastObservations() {

        $qb = $this->createQueryBuilder('o');
        $qb ->select('o')
            ->leftJoin('o.species', 's')
            ->orderBy('o.obsDate','DESC');

        return $qb
            ->getQuery()
            ->getResult();
    }

    // find the most recent observation of each species
    public function findMostRecentForEachSpecies()
    {

    }
}