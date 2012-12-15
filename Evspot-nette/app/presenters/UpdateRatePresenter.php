<?php
use Nette\Application\UI;

/**
 * UpdateRate presenter.
 */
class UpdateRatePresenter extends BasePresenter
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
    $this->deviceRepository = $this->context->deviceRepository;
    $this->cathegoryRepository = $this->context->cathegoryRepository;
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
  
  
  public function renderDefault($id)
  {
    $this->row = $this->rateRepository->findById($id);
  }
  
  protected function createComponentUpdateRateForm()
	{
    $row = $this->row;//najdi riadok sadzby urcenej na update    
    
    $form = new UI\Form($this,'updateRateForm');
    
    $form->addText('popis', 'Popis sazby:')
			->setRequired('Zadajte popis sadzby!');
    $form->addText('cena', 'Cena:')
			->setRequired('Zadajte cenu sadzby!')
      ->addRule($form::FLOAT, 'Cena musí obsahovať číslo!')
      ->addRule($form::RANGE, 'Cena musí byť > 0', array(0, 100));

    $form->addHidden('id');   // id_zar ID sadzby pre update ako hidden

    $form->addSubmit('update','ULOŽIŤ zmeny')
            ->onClick[] = $this->updateRateFormSubmitted;
            
    $form->addSubmit('cancel','ZRUŠIŤ')
            ->setValidationScope(FALSE)
            ->onClick[] = $this->updateRateFormCanceled;
            
    if (!$form->getForm()->isSubmitted()) {
      $form->setDefaults(array(
        'popis' => $row->Popis,
        'cena' => $row->Cena,
        'id' => $row->id_s,
      ));
    }
    
		return $form;
  }
  
  public function updateRateFormSubmitted($form)
	{
    $values = $form->getForm()->getValues();

    $this->rateRepository->updateRate($values->popis,$values->cena,$values->id);
      
    $this->redirect('Sadzby:'); // presmeruj na vypis sazdby - ADMIN     
  }


  public function updateRateFormCanceled($form)
	{
    $this->redirect('Sadzby:'); // presmeruj na stranku vypisu sadzby - admin  
  }

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}


}
