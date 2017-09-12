<?php
namespace AppBundle\Form;

use AppBundle\AppBundle;
use AppBundle\Entity\Species;
use AppBundle\Repository\SpeciesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Range;

class ObservationsType extends AbstractType
{
    /**
     * @var SpeciesRepository
     */
    private $speciesRepository;

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('number', NumberType::class, array(
				'label' => 'Nombre rencontré',
				'attr'	=> ['class' => 'form-control'],
				'constraints'	=> [
					new GreaterThanOrEqual(
						array(
							"value"		=>	"1",
							"message"	=>	"Le nombre observé doit être supérieur à 0"
						)
					)
				]
			))
			->add('pictures', FileType::class, array(
				'label' 		=>	'Image JPG',
				'attr'			=>	['class' => 'form-control'],
				'required'		=>	false
			))
			->add('longitude', NumberType::class, array(
				'label' 		=> 'Longitude',
				'attr'			=> ['class' => 'form-control'],
				'constraints'	=> [
					new Range(
						array(
							"min" 	=> 	"-180",
							"max"	=>	"180",
							"minMessage"	=>	"La longitude doit être supérieur à -180",
							"maxMessage"	=>	"La longitude doit être inférieur à 180",
						)
					),
				]
			))
			->add('latitude', NumberType::class, array(
				'label' => 'Latitude',
				'attr'	=> ['class' => 'form-control'],
				'constraints'	=> [
					new Range(
						array(
							"min" 	=> 	"-90",
							"max"	=>	"90",
							"minMessage"	=>	"La longitude doit être supérieur à -90",
							"maxMessage"	=>	"La longitude doit être inférieur à 90",
						)
					),
				]
			))
			->add('obsDate', DateTimeType::class, array(
				'label'				=> 'Date d\'observation',
				'date_format'	 	=> 'dd/MM/yyyy',
				'placeholder' 		=> array(
					'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
					'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
				),
				'constraints'		=> [
					new LessThanOrEqual(
						array(
							"value" 	=> "today",
							"message" 	=> "La date doit être inférieur ou égale à celle d'aujourd'hui"
						)
					),
				]
			))
			->add('submit', SubmitType::class, array(
				'label'	=> 	'Ajouter',
				'attr'	=>	['class' => 'btn btn-primary']
			))
            ->add('species', EntityType::class, array(
                //	on inverse les clés et valeurs
                'class' => 'AppBundle:Species',
                'choices'	=> $this->speciesRepository->findBy(array(), array("id" => "ASC")),
                'label'		=> "Espèce d'oiseau rencontré",
                'attr'	=> ['class' => 'form-control'],
            ));

	}
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Observations'
		));
	}
	public function getBlockPrefix()
	{
		return 'appbundle_observations';
	}

    /**
     * @param SpeciesRepository $speciesRepository
     */
    public function setSpeciesRepository($speciesRepository)
    {
        $this->speciesRepository = $speciesRepository;
    }

}