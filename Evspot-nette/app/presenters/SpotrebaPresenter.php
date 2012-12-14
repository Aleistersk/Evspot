<?php
use Nette\Application\UI;
use Nette\Utils\Arrays;

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
  { //odovzdanie vsetkych riadkov tab.kategoria sablone
    $this->template->rows=$this->cathegoryRepository->findAll('kategoria');
    //lokalna premenna $rows so vsetkymi riadkami tab. kat.
    $rows=$this->cathegoryRepository->findAll('kategoria');
    $array_o=array(); //pole pre odhadovanu spotrebu a sumarizaciu
    $array_n=array(); // pole pre nam. spotrebu a sumarizaciu
    //pre kazdy riadok tab. kategoria 
    foreach ($rows as $row) {
          // vypocitaj sum() v jednotlivych kategoriach odh. sp. ako aj nam. spot.
         $suma_o = $this->deviceRepository->sumOdhSpotKat($row->id_kat,$this->userId);
         $suma_n = $this->deviceRepository->sumNamSpotKat($row->id_kat,$this->userId);
         Arrays::insertAfter($array_o,$row->Nazov,array($row->Nazov => $suma_o));
         Arrays::insertAfter($array_n,$row->Nazov,array($row->Nazov => $suma_n));
    }
    
    $this->template->array_o=$array_o; // odovzdaj sablone pole sum odh. spot. podla kat.
    $this->template->array_n=$array_n; // odovzdaj sablone pole sum nam.spot. podla kat.
    // odovzdaj sablone sumar odh.spot. vsetkych spotr., cize vsetko spolu pre usera
    $this->template->spolu_o=$this->deviceRepository->sumOdhSpotAll($this->userId);
    // odovzdaj sablone sumar nam.spot. vsetkych spotr., cize vsetko spolu pre usera
    $this->template->spolu_n=$this->deviceRepository->sumNamSpotAll($this->userId); 
    
    //vypocet ceny za odh. a nameranu spotrebu vsetkych zariadeni usera
    $rows=$this->deviceRepository->findByIdp($this->userId);
    
    $celkom_o=0; // pomocna premenna
    $celkom_n=0; // pomocna premenna
    
    foreach ($rows as $row){
        //cena sadzby pre dane zariadenie
        $cena_row=$this->rateRepository->findById($row->id_s);
        $cena_odh = $row->odh_spot * $cena_row->Cena;
        $cena_nam = $row->nam_spot * $cena_row->Cena;
        $celkom_o+=$cena_odh;
        $celkom_n+=$cena_nam;    
    }
    
    $this->template->cena_o = $celkom_o;
    $this->template->cena_n = $celkom_n;
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
