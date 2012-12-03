<?php
use Nette\Application\UI;

/**
 * UserPage presenter.
 */
class UserPagePresenter extends BasePresenter
{


	/** @var Evspot\UserRepository */
	private $userRepository;
	/** @var Evspot\DeviceRepository */
	private $deviceRepository;
	/** @var Evspot\CathegoryRepository */
	private $cathegoryRepository;
  
  private $userId;

	public function inject(Evspot\UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
    $this->deviceRepository = $this->context->deviceRepository;
    $this->cathegoryRepository = $this->context->cathegoryRepository;
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
    $this->template->devices = $this->deviceRepository->findByIdp($this->userId);
  }
  
  protected function createComponentAddDeviceForm()
	{
    $catPairs = $this->cathegoryRepository->findAll('kategoria')->fetchPairs('id_kat', 'Nazov') ;
    $form = new UI\Form;
    $form->addSubmit('add','PRIDAŤ zariadenie')
            ->setAttribute('class', 'tlacitko')
            ->onClick[] = $this->addDeviceFormSubmitted;
    $form->addSubmit('vypis','Celková spotreba')
            ->setAttribute('class', 'tlacitko')
            ->onClick[] = $this->vypisSpotFormSubmitted;
            
    $form->addSelect('kategoria','KATEGÓRIA:',$catPairs)
            ->setPrompt('- VŠETKY -');
		return $form;
  }
  
  public function addDeviceFormSubmitted($form)
	{
    $this->redirect('Device:'); // presmeruj na pridanie zariadenia    
  }

  public function vypisSpotFormSubmitted($form)
	{
    $this->redirect('Spotreba:'); // presmeruj na vypis celkovej spotreby    
  }

	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}

  public function handleDeleteRow($id)
	{
		$this->deviceRepository->deleteRow($id); // volaj delete metodu
		$this->redirect('this');
	}
  
  public function handleUpdateRow($id)
	{
		// TODO:Update
		$this->redirect('this');
	}

}
