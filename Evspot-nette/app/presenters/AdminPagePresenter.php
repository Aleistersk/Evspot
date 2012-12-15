<?php
use Nette\Application\UI;
use Nette\Templating\Template;

/**
 * AdminPage presenter.
 */
class AdminPagePresenter extends BasePresenter
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
      $this->template->kategorie = $this->cathegoryRepository->findAll('kategoria');
  }
  
  
  protected function createComponentSadzbyForm()
	{
    $form = new UI\Form($this,'sadzbyForm');
    $form->addSubmit('sadzby','SADZBY')
            ->setAttribute('class', 'tlacitko')
            ->onClick[] = $this->sadzbyFormSubmitted;
		return $form;
  }
  
  protected function createComponentAddKatForm()
	{
    $form = new UI\Form($this,'addKatForm');
    $form->addSubmit('add','PRIDAŤ kategóriu')
            ->setAttribute('class', 'tlacitko')
            ->onClick[] = $this->addKatFormSubmitted;
  }

  
  //funkcia pre presmerovanie na vypis tab. sadzieb
  public function sadzbyFormSubmitted($form)
	{
    $this->redirect('Sadzby:'); // presmeruj na Sadzby a ich IUD stranku    
  }


  //funkcia pre presmerovanie na pridanie kategorie
  public function addKatFormSubmitted($form)
	{
    $this->redirect('Cathegory:'); // presmeruj na form pre pridanie kategorie    
  }


	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}

  public function handleDeleteRow($id)
	{
		$this->cathegoryRepository->deleteRow($id); // volaj delete metodu
		$this->redirect('this');
	}
  
  public function handleUpdateRow($id)
	{
		// presmerovanie na update stranku s formularom, parametrom je id_kat
		$this->redirect('UpdateKat:',$id);
	}

}
