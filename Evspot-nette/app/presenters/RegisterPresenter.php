<?php
use Nette\Application\UI;

/**
 * Register presenter.
 */
class RegisterPresenter extends BasePresenter
{

	/** @var Evspot\UserRepository */
	private $userRepository;

	/** @var \Nette\Database\Table\ActiveRow */
	private $row;


	public function inject(Evspot\UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;

	}



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

        	$values = $form->getValues(); // nacitaj hodnoty formulara
			
		$this->row = $this->userRepository-> findByEmail($values->email); //hladaj v DB pouzivatela podla zadanej email adresy

		if ($this->row === FALSE) { // ak neexistuje pouzivatelske konto s danou email adresou

			//hladaj v DB pouzivatela podla zadaneho nickname
			$this->row = $this->userRepository-> findByName($values->nickname); 

			if($this->row === FALSE){ // ak neexistuje v DB, vykonaj registraciu

				//registracia vlozenim do tabulky v DB
				$this->row = $this->userRepository->registerUser($values);

				if($this->row === FALSE) { // ak sa nepodarilo vlozit pouzivatela do DB
					// vypis chybu
					$form->addError('CHYBA! Nepodarilo sa vytvoriť používateľské konto!');
				
				}
				else{ // inak insert do DB bol uspeny a pouzivatel je registrovany
				     $this->flashMessage('Boli ste úspešne zaregistrovaný. Teraz sa možete prihlásiť pod Vaším používateľským menom: '.$values->nickname, 'success');
        		
	        	    	     $this->redirect('Sign:in'); // presmeruj na prihlasenie
				
				}

			}
			else{ // ina vypis chybu
				$form->addError('Používateľ so zadaným používateľským menom \''.$this->row['Nickname'].'\' už existuje!');
			}
 		}
		else{ // inak vypis error o uz pouzitom mene resp. email adrese pouzivatela vo form
			$form->addError('Pre zadanú emailovú adresu \''.$this->row['Email'].'\' už existuje používateľské konto!');
		}

	}




}
