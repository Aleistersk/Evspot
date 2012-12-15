<?php
use Nette\Application\UI;
use Nette\Templating\Template;

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
  private $kategoria='';

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
  
  public function renderChange($kategoria)
  {
    $this->template->devices = $this->deviceRepository->findByIdpKat($this->userId,$kategoria);
    $this->kategoria=$kategoria; // zapamataj si zvolenu kategoriu
    
  }
  
  protected function createComponentAddDeviceForm()
	{
    $catPairs = $this->cathegoryRepository->findAll('kategoria')->fetchPairs('id_kat', 'Nazov') ;
    $form = new UI\Form($this,'addDeviceForm');
    $form->addSubmit('add','PRIDAŤ zariadenie')
            ->setAttribute('class', 'tlacitko')
            ->onClick[] = $this->addDeviceFormSubmitted;
    $form->addSubmit('vypis','Celková spotreba')
            ->setAttribute('class', 'tlacitko')
            ->onClick[] = $this->vypisSpotFormSubmitted;
            
    $form->addSelect('kategoria','KATEGÓRIA:',$catPairs)
            ->setPrompt('- VŠETKY -')
            ->setAttribute('onchange', 'submit()');
            
    $form->onSuccess[] = $this->changeVypis;
    
    if (!$form->getForm()->isSubmitted()) {
      $form->setDefaults(array(
        'kategoria' => $this->kategoria,
      ));
    }
    
    
		return $form;
  }
  
  //funkcia na zmenu vypisu zariadeni podla zvolenej kategorie (bez vyberu vsetky)
  public function changeVypis($form)
  {
    $values = $form->getValues();
    $this->kategoria=$values->kategoria;
    //pokial je kategoria NULL
    if($this->kategoria===NULL){
      $this->redirect('UserPage:'); // redirect na Userpage - chceme vypisat vsetky zariadenia
    }
    else{   // inak je vypis zariadeni podla kategorie
      $this->redirect('UserPage:change',$this->kategoria); // presmeruj na change template
    }
  }
  
  //funkcia pre presmerovanie na pridanie zariadenia
  public function addDeviceFormSubmitted($form)
	{
    $this->redirect('Device:'); // presmeruj na pridanie zariadenia    
  }

  //funkcia pre presmerovanie na vypis celkovej dennej spotreby
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
		// presmerovanie na update stranku s formularom, parametrom je id_zar
		$this->redirect('Update:default',$id);
	}

}
