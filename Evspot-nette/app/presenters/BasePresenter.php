<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var Todo\UserRepository */
	private $userRepository;

	public function injectBase(Evspot\UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}



}
