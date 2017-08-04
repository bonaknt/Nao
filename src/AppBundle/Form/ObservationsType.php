<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ObservationsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('species', ChoiceType::class, array(
				'label' => 'Espèce d\'oiseau rencontré'
			))
			->add('number', NumberType::class, array(
				'label' => 'Nombre rencontré'
			))
			->add('longitude', NumberType::class, array(
				'label' => 'Longitude'
			))
			->add('latitude', NumberType::class, array(
				'label' => 'Latitude'
			))
			->add('obsDate', DateTimeType::class, array(
				'label' => 'Date d\'observation',
				'placeholder' => array(
					'year' => 'Année', 'day' => 'Jour', 'month' => 'Mois',
					'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Second',
				)
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