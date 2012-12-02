<?php
use Nette\Application\UI;

/**
 * Spotreba presenter.
 */
class SpotrebaPresenter extends BasePresenter
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
    $this->template->pocet=$this->cathegoryRepository->countCath();
    $this->template->rows=$this->cathegoryRepository->findAll('kategoria');
  }
  
  protected function createComponentBackForm()
	{
    $form = new UI\Form;
    $form->addSubmit('back','HL. STRÁNKA')
            ->setAttribute('class', 'tlacitko')
            ->onClick[] = $this->backFormSubmitted;
		return $form;
  }


  public function backFormSubmitted($form)
	{
    $this->redirect('UserPage:'); // presmeruj na hl. stranku usera    
  }
  
  
	public function handleSignOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Boli ste úspešne odhlásený. Môžete sa znova prihlásiť.');
		$this->redirect('Sign:in');
	}


}
