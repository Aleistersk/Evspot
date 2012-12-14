<?php
use Nette\Application\UI;

/**
 * Update presenter.
 */
class UpdatePresenter extends BasePresenter
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
		if(!$this->getUser()->isLoggedIn()){
			$this->redirect('Sign:in');
      $this->id_z = $id; // zapamataj id zariadenia pre jeho update
		}
  
  }
  
  
  public function renderDefault($id)
  {
    $this->row = $this->deviceRepository->findById($id);
  }
  
  protected function createComponentUpdateDeviceForm()
	{
    $catPairs = $this->cathegoryRepository->findAll('kategoria')->fetchPairs('id_kat', 'Nazov') ;
    $sadzbaPairs = $this->rateRepository->findAll('sadzba')->fetchPairs('id_s','Popis');

    $row = $this->row;//najdi riadok zariadenia urceneho na update    
    
    $form = new UI\Form($this,'updateDeviceForm');
    
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
            
    $form->addHidden('id');   // id_zar ID zariadenia pre update ako hidden

    $form->addSubmit('update','ULOŽIŤ zmeny')
            ->onClick[] = $this->updateDeviceFormSubmitted;
            
    $form->addSubmit('cancel','ZRUŠIŤ')
            ->setValidationScope(FALSE)
            ->onClick[] = $this->updateDeviceFormCanceled;
            
    if (!$form->getForm()->isSubmitted()) {
    $form->setDefaults(array(
        'nazov' => $row->Nazov,
        'odhadc' => $row->odh_cas,
        'prikon' => $row->Prikon,
        'namspot' => $row->nam_spot,
        'kategoria' => $row->id_kat,
        'sadzba' => $row->id_s,
        'id' => $row->id_zar,
    ));
    }
    
		return $form;
  }
  
  public function updateDeviceFormSubmitted($form)
	{
    $values = $form->getForm()->getValues();

    $this->deviceRepository->updateDevice($values->nazov,$values->odhadc,$values->prikon,$values->namspot,$values->kategoria,($values->odhadc*$values->prikon),$values->sadzba,$values->id);
      
    $this->redirect('Userpage:'); // presmeruj na domacu str. pouzivatela    
  }

  public function updateDeviceFormCanceled($form)
	{
    $this->redirect('Userpage:'); // presmeruj na domacu stranku pouzivatela   
  }

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}


}
