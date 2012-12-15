<?php
use Nette\Application\UI;

/**
 * Cathegory presenter.
 */
class CathegoryPresenter extends BasePresenter
{


	/** @var Evspot\UserRepository */
	private $userRepository;
	/** @var Evspot\DeviceRepository */
	private $deviceRepository;
	/** @var Evspot\CathegoryRepository */
	private $cathegoryRepository;
	/** @var Evspot\CathegoryRepository */
	private $rateRepository;
  
  private $userId;

	public function inject(Evspot\UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
    $this->cathegoryRepository = $this->context->cathegoryRepository;
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
  
  protected function createComponentAddKatForm()
	{    
    $form = new UI\Form;
    $form->addText('nazov', 'Názov novej kategórie:',30)
			->setRequired('Zadajte názov novej kategórie!');
 		$form->addSubmit('add','PRIDAŤ');
		$form->addSubmit('cancel', 'ZRUŠIŤ')->setValidationScope(FALSE)
			->onClick[] = callback($this, 'addKatFormCanceled');

   // call method adddeviceFormSubmitted() on success
		$form->onSuccess[] = $this->addKatFormSubmitted;
    
		return $form;
  }
  
  public function addKatFormCanceled($form){
           $this->redirect('AdminPage:');
	}

  
  public function addKatFormSubmitted($form)
	{
    $values = $form->getValues();     
    $this->cathegoryRepository->addCathegory($values);
 		$this->redirect('AdminPage:');     
  }

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}


}
