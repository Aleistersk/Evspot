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

	/* Vyhladanie pouzivatela podla emailu */
	public function findByEmail($email)
	{
    		return $this->findAll('pouzivatel')->where('email', $email)->fetch();
	}	


	/* Registracia pouzivatela vlozenim do tabulky DB */
	public function registerUser($values)
	{
		return $this->getTable('pouzivatel')->insert(array(
			'Meno' => $values->meno,
			'Priezvisko' => $values->priezvisko,
			'Nickname' => $values->nickname,
			'Email' => $values->email,
			'Heslo' => Authenticator::calculateHash($values->heslo),
		));
	}



}