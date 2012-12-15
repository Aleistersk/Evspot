<?php
use Nette\Application\UI;

/**
 * Update cathegory presenter.
 */
class UpdateKatPresenter extends BasePresenter
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
  
  /** @var object */
  private $row;

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
  
  
  public function renderDefault($id)
  {
    $this->row = $this->cathegoryRepository->findById($id);
  }
  
  protected function createComponentUpdateKatForm()
	{

    $row = $this->row;//najdi riadok kategorie urcenej na update    
    
    $form = new UI\Form($this,'updateKatForm');
    
    $form->addText('nazov', 'Názov kategórie:',30)
			->setRequired('Zadajte názov kategórie!');

    $form->addHidden('id');   // id_kat ID kategorie pre update ako hidden

    $form->addSubmit('update','ULOŽIŤ zmeny')
            ->onClick[] = $this->updateKatFormSubmitted;
            
    $form->addSubmit('cancel','ZRUŠIŤ')
            ->setValidationScope(FALSE)
            ->onClick[] = $this->updateKatFormCanceled;
            
    if (!$form->getForm()->isSubmitted()) {
      $form->setDefaults(array(
        'nazov' => $row->Nazov,
        'id' => $row->id_kat,
      ));
    }
    
		return $form;
  }
  
  public function updateKatFormSubmitted($form)
	{
    $values = $form->getForm()->getValues();

    $this->cathegoryRepository->updateCath($values->nazov, $values->id);
      
    $this->redirect('AdminPage:'); // presmeruj na domacu str. admina    
  }

  public function updateKatFormCanceled($form)
	{
    $this->redirect('AdminPage:'); // presmeruj na domacu stranku admina   
  }

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}


}
