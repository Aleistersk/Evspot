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



}