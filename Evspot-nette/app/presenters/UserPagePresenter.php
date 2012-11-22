<?php
use Nette\Application\UI;

/**
 * UserPage presenter.
 */
class UserPagePresenter extends BasePresenter
{


	/** @var Evspot\UserRepository */
	private $userRepository;


	public function inject(Evspot\UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;

	}


	protected function startup()
	{
		parent::startup();
		if(!$this->getUser()->isLoggedIn()){
			$this->redirect('Sign:in');
		}

	}



	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}


}
