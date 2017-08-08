<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ObservationsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('number', NumberType::class, array(
				'label' => 'Nombre rencontré',
				'attr'	=> ['class' => 'form-control'],
			))
			->add('longitude', NumberType::class, array(
				'label' => 'Longitude',
				'attr'	=> ['class' => 'form-control'],
				'constraints'	=> [
					new LessThanOrEqual(
						array(
							"value" => "180",
							"message" => "La longitude doit être comprise entre 180 et -180"
						)
					),
					new GreaterThanOrEqual(
						array(
							"value" => "-180",
							"message" => "La longitude doit être comprise entre 180 et -180"
						)
					)
				]
			))
			->add('latitude', NumberType::class, array(
				'label' => 'Latitude',
				'attr'	=> ['class' => 'form-control'],
				'constraints'	=> [
					new LessThanOrEqual(
						array(
							"value" => "90",
							"message" => "La longitude doit être comprise entre 90 et -90"
						)
					),
					new GreaterThanOrEqual(
						array(
							"value" => "-90",
							"message" => "La longitude doit être comprise entre 90 et -90"
						)
					)
				]
			))
			->add('obsDate', DateType::class, array(
				'label' => 'Date d\'observation',
				'format'	 	=> 'dd-MM-yyyy',
				'constraints'	=> [
					new LessThanOrEqual(
						array(
							"value" => "today",
							"message" => "La date doit être inférieur ou égale à celle d'aujourd'hui"
						)
					),
				]
			))
			->add('submit', SubmitType::class, array(
				'label'	=> 	'Ajouter',
				'attr'	=>	['class' => 'btn btn-primary']
			))
		;
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
}