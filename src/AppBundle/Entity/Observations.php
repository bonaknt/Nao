<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Observations
 *
 * @ORM\Table(name="observations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObservationsRepository")
 */
class Observations
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     * @var int
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Species", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(name="species", type="integer")
     */
    private $species;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

	/**
	 * @var array
	 *
	 * @ORM\Column(name="pictures", type="array")
	 */
	private $pictures;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="validated", type="boolean")
	 */
	private $validated = 0;

	/**
	 * @var datetime
	 *
	 * @ORM\Column(name="obs_date", type="datetime")
	 */
	private $obsDate;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Observations
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set species
     *
     * @param string $species
     *
     * @return Observations
     */
    public function setSpecies($species)
    {
        $this->species = $species;

        return $this;
    }

    /**
     * Get species
     *
     * @return string
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Observations
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Observations
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Observations
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set pictures
     *
     * @param array $pictures
     *
     * @return Observations
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;

        return $this;
    }

    /**
     * Get pictures
     *
     * @return array
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     *
     * @return Observations
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set obsDate
     *
     * @param \DateTime $obsDate
     *
     * @return Observations
     */
    public function setObsDate($obsDate)
    {
        $this->obsDate = $obsDate;

        return $this;
    }

    /**
     * Get obsDate
     *
     * @return \DateTime
     */
    public function getObsDate()
    {
        return $this->obsDate;
    }
}
