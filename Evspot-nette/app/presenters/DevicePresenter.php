<?php
use Nette\Application\UI;

/**
 * Device presenter.
 */
class DevicePresenter extends BasePresenter
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
    $this->deviceRepository = $this->context->deviceRepository;
    $this->cathegoryRepository = $this->context->cathegoryRepository;
    $this->rateRepository = $this->context->rateRepository;
    $this->userId = $this->getUser()->getId();
	}


	protected function startup()
	{
		parent::startup();
		if(!$this->getUser()->isLoggedIn()){
			$this->redirect('Sign:in');
		}
  
  }
  
  
  public function renderDefault()
  {
    $this->template->devices = $this->deviceRepository->findAll('zariadenie');
    $this->template->test=$this->userId;
  }
  
  protected function createComponentAddDeviceForm()
	{
    $catPairs = $this->cathegoryRepository->findAll('kategoria')->fetchPairs('id_kat', 'Nazov') ;
    $sadzbaPairs = $this->rateRepository->findAll('sadzba')->fetchPairs('id_s','Popis');
    
    $form = new UI\Form;
    $form->addText('nazov', 'Názov zariadenia:')
			->setRequired('Zadajte názov zariadenia!');
    $form->addText('odhadc', 'Odhadovaný čas/deň:')
			->setRequired('Zadajte odhadovaný čas!')
      ->addRule($form::FLOAT, 'Odhadovaný čas používania musí obsahovať číslo!')
      ->addRule($form::RANGE, 'Odhadovaný čas pouťívania musí byť > 0', array(0, 100));
    $form->addText('prikon', 'PRÍKON:')
			->setRequired('Zadajte príkon zariadenia!')
      ->addRule($form::FLOAT, 'Príkon musí obsahovať číslo!')
      ->addRule($form::RANGE, 'Príkon musí byť > 0', array(0, 100000));;
    $form->addText('namspot', 'Nameraná denná spotreba:')
			->setRequired('Zadajte nameranú dennú spotrebu!')
      ->addRule($form::FLOAT, 'Nameraná denná spotreba musí obsahovať číslo!')
      ->addRule($form::RANGE, 'Nameraná denná spotreba musí byť > 0', array(0, 1000000));;
            
    $form->addSelect('kategoria','KATEGÓRIA:',$catPairs)
            ->setPrompt('-Vyberte kategóriu-')
            ->addRule($form::FILLED, 'Musíte si zvoliť kategoriu!');

    $form->addSelect('sadzba','SADZBA:',$sadzbaPairs)
            ->setPrompt('-Vyberte sadzbu-')
            ->addRule($form::FILLED, 'Musíte si zvoliť sadzbu!');

		$form->addSubmit('add','PRIDAŤ');
		$form->addSubmit('cancel', 'ZRUŠIŤ')->setValidationScope(FALSE)
			->onClick[] = callback($this, 'addDeviceFormCanceled');

   // call method adddeviceFormSubmitted() on success
		$form->onSuccess[] = $this->addDeviceFormSubmitted;
    
		return $form;
  }
  
  public function addDeviceFormCanceled($form){
           //$this->flashMessage('Zrušili ste pridanie nového zariadenia. Pre opätovné pridanie vyplňte formulár a kliknite na tlačítko PRIDAŤ.');
           //$this->redirect('Device:add');
           $this->redirect('UserPage:');
	}

  
  public function addDeviceFormSubmitted($form)
	{
    $values = $form->getValues(); 
    
    $this->deviceRepository->addDevice($values->nazov,$values->odhadc,$values->prikon,$values->namspot,$values->kategoria,($values->odhadc*$values->prikon),$this->userId,$values->sadzba);
      
    //$this->flashMessage('Uspesne pridane zariadenie.');
 		$this->redirect('Userpage:');     
  }

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}


}
