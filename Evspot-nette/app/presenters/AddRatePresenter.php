<?php
use Nette\Application\UI;

/**
 * AddRate presenter.
 */
class AddRatePresenter extends BasePresenter
{


	/** @var Evspot\UserRepository */
	private $userRepository;
	/** @var Evspot\CathegoryRepository */
	private $rateRepository;
  
  private $userId;

	public function inject(Evspot\UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
    $this->rateRepository = $this->context->rateRepository;
    $this->userId = $this->getUser()->getId();
	}


	protected function startup()
	{
		parent::startup();
    $userName=$this->getUser()->getIdentity()->Nickname;
		if(!$this->getUser()->isLoggedIn()){
			$this->redirect('Sign:in');
		}
    else if($userName!='Admin'){
      $this->redirect('UserPage:');
    }
  }
  
  
  public function renderDefault()
  {
  }
  
  protected function createComponentAddRateForm()
	{    
    $form = new UI\Form;
    $form->addText('popis', 'Popis novej sadzby:',30)
			->setRequired('Zadajte popis novej sadzby!');

    $form->addText('cena', 'Cena novej sadzby:',30)
			->setRequired('Zadajte cenu novej sadzby!')
      ->addRule($form::FLOAT, 'Cena musí obsahovať číslo!')
      ->addRule($form::RANGE, 'Cena musí byť > 0', array(0, 100));

 		$form->addSubmit('add','PRIDAŤ');
		$form->addSubmit('cancel', 'ZRUŠIŤ')->setValidationScope(FALSE)
			->onClick[] = callback($this, 'addRateFormCanceled');

   // call method addRateFormSubmitted() on success
		$form->onSuccess[] = $this->addRateFormSubmitted;
    
		return $form;
  }
  
  public function addRateFormCanceled($form){
           $this->redirect('Sadzby:');
	}

  
  public function addRateFormSubmitted($form)
	{
    $values = $form->getValues();     
    $this->rateRepository->addRate($values);
 		$this->redirect('Sadzby:');     
  }

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}


}
