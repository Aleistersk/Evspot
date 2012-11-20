<?php
namespace Evspot;

/**
 * Tabulka pouzivatel
 */
class UserRepository extends Repository
{

	public function findByName($nickname)
	{
    		return $this->findAll('pouzivatel')->where('nickname', $nickname)->fetch();
	}	

}