<?php
namespace Evspot;

/**
 * Tabulka zariadenie
 */
class DeviceRepository extends Repository
{
  /* Vyhladanie zariadenia podla nazvu */
	public function findByName($nazov)
	{
    		return $this->findAll('zariadenie')->where('Nazov', $nazov)->fetch();
	}	

	/* Vyhladanie zariadenia podla Id */
	public function findById($id)
	{
    		return $this->findAll('zariadenie')->where('id_zar', $id)->fetch();
	}	

  /* Vyhladanie zariadenia podla Id_pouzivatela */
	public function findByIdp($id)
	{
    		return $this->findAll('zariadenie')->where(array('id_p' => $id));
	}	

  /* Vyhladanie zariadenia podla Id_pouzivatela a kategorie*/
	public function findByIdpKat($id_p,$id_kat)
	{
    		return $this->findAll('zariadenie')->where(array('id_p' => $id_p, 'id_kat' => $id_kat));
	}	

  /* Vymazanie zariadenia podla Id_zariadenia */
	public function deleteRow($id)
	{
    		return $this->findAll('zariadenie')->where('id_zar', $id)->fetch()->delete();
	}	
  
  /* Suma odh.spotreby podla Id_zariadenia */
	public function sumOdhSpotKat($id_kat,$id_p)
	{
    		return $this->findAll('zariadenie')->where(array('id_kat' => $id_kat,'id_p' => $id_p))->sum("odh_spot");
	}	

  /* Suma vsetkych kat. odh.spotreby podla Id_pouzivatela */
	public function sumOdhSpotAll($id_p)
	{
    		return $this->findAll('zariadenie')->where(array('id_p' => $id_p))->sum("odh_spot");
	}	
  
  /* Suma nam.spotreby podla Id_zariadenia */
	public function sumNamSpotKat($id_kat,$id_p)
	{
    		return $this->findAll('zariadenie')->where(array('id_kat' => $id_kat,'id_p' => $id_p))->sum("nam_spot");
	}	

  /* Suma vsetkych kat. nam.spotreby podla Id_pouzivatela */
	public function sumNamSpotAll($id_p)
	{
    		return $this->findAll('zariadenie')->where(array('id_p' => $id_p))->sum("nam_spot");
	}	

	/* Pridanie noveho zariadenia vlozenim do tabulky DB */
	public function addDevice($nazov,$odhadc,$prikon,$namspot,$id_kat,$odhad,$userId,$id_s)
	{
		return $this->getTable('zariadenie')->insert(array(
			'Nazov' => $nazov,
			'odh_cas' => $odhadc,
			'Prikon' => $prikon,
			'odh_spot' => $odhad,
			'nam_spot' => $namspot,
      'id_kat' => $id_kat,
      'id_p' => $userId,
      'id_s' => $id_s,
		));
	}

	/* Uprava udajov (UPDATE) zariadenia v tabulke DB */
	public function updateDevice($nazov,$odhadc,$prikon,$namspot,$id_kat,$odhads,$id_s,$id_zar)
	{
		return $this->findById($id_zar)->update(array(
			'Nazov' => $nazov,
			'odh_cas' => $odhadc,
			'Prikon' => $prikon,
			'odh_spot' => $odhads,
			'nam_spot' => $namspot,
      'id_kat' => $id_kat,
      'id_s' => $id_s,
		));
	}

}