﻿<?php

use Nette\Application\UI;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new UI\Form;
		$form->addText('nickname','Používateľské meno*:',30)
			->setRequired('Prosím zadajte Vaše používateľské meno!');

		$form->addPassword('heslo','Heslo*:',30)
			->setRequired('Prosím zadajte Vaše heslo!');

		$form->addCheckbox('remember','Trvalé prihlásenie');

		$form->addSubmit('send','PRIHLÁSIŤ');
		$form->addSubmit('cancel', 'ZRUŠIŤ')->setValidationScope(FALSE)
			->onClick[] = callback($this, 'signInFormCanceled');

		// call method signInFormSubmitted() on success
		$form->onSuccess[] = $this->signInFormSubmitted;
		return $form;
	}



	public function signInFormCanceled($form){
            $this->flashMessage('Zrušili ste prihlásenie do systému. Pre opätovné prihlásenie vyplňte formulár a kliknite na tlačítko PRIHLÁSIŤ.');
            $this->redirect('Sign:in');
	}


	public function signInFormSubmitted($form)
	{

		try {
        		$user = $this->getUser();
        		$values = $form->getValues();
        		if ($values->remember) {
            			$user->setExpiration('+30 days', FALSE);
        		}
        		$user->login($values->nickname, $values->heslo);
        		$this->flashMessage('Prihlasenie bolo uspesne.', 'success');
        		$this->redirect('UserPage:');
    		} 
		catch (Nette\Security\AuthenticationException $e) {
        		$form->addError('Neplatne pouzivatelske meno alebo heslo.');
    		}




		//$this->redirect('UserPage:');
	}



	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('in');
	}

}