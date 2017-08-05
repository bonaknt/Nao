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

class ObservationsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('species', ChoiceType::class, array(
				'label' => 'Espèce d\'oiseau rencontré',
				'attr'	=> ['class' => 'form-control'],
			))
			->add('number', NumberType::class, array(
				'label' => 'Nombre rencontré',
				'attr'	=> ['class' => 'form-control'],
			))
			->add('longitude', NumberType::class, array(
				'label' => 'Longitude',
				'attr'	=> ['class' => 'form-control'],
			))
			->add('latitude', NumberType::class, array(
				'label' => 'Latitude',
				'attr'	=> ['class' => 'form-control'],
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
				'label'	=> 'Ajouter',
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