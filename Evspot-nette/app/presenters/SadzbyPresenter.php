<?php
use Nette\Application\UI;
use Nette\Templating\Template;

/**
 * Sadzby presenter.
 */
class SadzbyPresenter extends BasePresenter
{


	/** @var Evspot\UserRepository */
	private $userRepository;
	/** @var Evspot\RateRepository */
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
      $this->template->sadzby = $this->rateRepository->findAll('sadzba');
  }
  
  
  protected function createComponentKatForm()
	{
    $form = new UI\Form($this,'katForm');
    $form->addSubmit('kategoria','KATEGÓRIE')
            ->setAttribute('class', 'tlacitko')
            ->onClick[] = $this->katFormSubmitted;
		return $form;
  }
  
  protected function createComponentAddSadzbaForm()
	{
    $form = new UI\Form($this,'addSadzbaForm');
    $form->addSubmit('add','PRIDAŤ sadzbu')
            ->setAttribute('class', 'tlacitko')
            ->onClick[] = $this->addSadzbaFormSubmitted;
  }

  
  //funkcia pre presmerovanie na vypis tab. kategorii
  public function katFormSubmitted($form)
	{
    $this->redirect('AdminPage:'); // presmeruj na Kategorie a ich IUD stranku    
  }


  //funkcia pre presmerovanie na pridanie sadzby
  public function addSadzbaFormSubmitted($form)
	{
    $this->redirect('AddRate:'); // presmeruj na form pre pridanie sadzby    
  }


	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}

  public function handleDeleteRow($id)
	{
		$this->rateRepository->deleteRow($id); // volaj delete metodu
		$this->redirect('this');
	}
  
  public function handleUpdateRow($id)
	{
		// presmerovanie na update stranku s formularom, parametrom je id_s
		$this->redirect('UpdateRate:',$id);
	}

}
