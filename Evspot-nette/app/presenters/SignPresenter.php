<?php

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
        		//$this->flashMessage('Prihlasenie bolo uspesne.', 'success');
            //test, ci je prihlaseny admin
            if($values->nickname==="Admin"){
                $this->redirect('AdminPage:'); //ak je to admin, presmeruj na jeho homepage
            }
            else{  // inak je to user
        		    $this->redirect('UserPage:'); // presmeruj na userpage
                }
    		} 
		catch (Nette\Security\AuthenticationException $e) {
        		$form->addError('Neplatné používateľské meno, alebo heslo. Zadajte znova!');
    		}

	}



	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste odhlásený zo systému.');
		$this->redirect('in');
	}

}
