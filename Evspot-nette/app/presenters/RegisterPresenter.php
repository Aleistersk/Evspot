<?php
use Nette\Application\UI;

/**
 * Register presenter.
 */
class RegisterPresenter extends BasePresenter
{

	/**
	 * REGISTER form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentRegisterForm()
	{
		$form = new UI\Form;
		$form->addText('meno','Meno:',30);

		$form->addText('priezvisko','Priezvisko:',30);

		$form->addText('email','E-mail*:',30)
			->setEmptyValue('@')
			->addRule(UI\Form::EMAIL, 'Zadajte prosím platný e-mail!');

		$form->addText('nickname','Používateľské meno*:',30)
			->setRequired('Prosím zadajte Vaše používateľské meno!');

		$form->addPassword('heslo','Heslo*:',30)
			->setRequired('Prosím zadajte Vaše heslo!');


		$form->addSubmit('register','REGISTROVAŤ');

		$form->addSubmit('cancel', 'ZRUŠIŤ')->setValidationScope(FALSE)
			->onClick[] = callback($this, 'registerFormCanceled');

		// call method registerFormSubmitted() on success
		$form->onSuccess[] = $this->registerFormSubmitted;
		return $form;
	}



	public function registerFormCanceled($form){
            $this->flashMessage('Zrušili ste registráciu do systému. Pre opätovnú registráciu prosím vyplňte formulár a kliknite na tlačítko REGISTROVAŤ.');
            $this->redirect('Register:');
	}


	public function registerFormSubmitted($form)
	{
		$values = $form->getValues();


		$this->redirect('Sign:in');
	}




}
