<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DescriptionType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('description', TextAreaType::class, array(
				'label' => 'Description de l\'oiseau',
				'attr'	=> [
					'class' => 'form-control',
					'rows'	=>	'15',
					'style'	=>	'overflow:auto;resize:vertical;'
				]
			))
			->add('submit', SubmitType::class, array(
				'label'	=> 	'Changer la description',
				'attr'	=>	['class' => 'btn btn-primary ']
			))
		;
	}
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Species'
		));
	}
	public function getBlockPrefix()
	{
		return 'appbundle_Species';
	}
}