<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Email;

class NewsletterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', EmailType::class, array(
				'label'			=>	false,
				'attr'	=>	[
					'placeholder' => 'Adresse email',
					'name' => 'email',
					'class' => 'form-control',
				]
			))
			->add('submit', SubmitType::class, array(
				'label'	=> 	'S\'INSCRIRE',
				'attr'	=>	[
					'class' => 'btn btn-default form-control',
				]
			))
		;
	}
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\Newsletter'
		));
	}
	public function getBlockPrefix()
	{
		return 'appbundle_Newsletter';
	}
}