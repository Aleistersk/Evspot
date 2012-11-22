<?php

namespace Evspot;


use Nette,
	Nette\Security,
	Nette\Utils\Strings;


/**
 * Users authenticator.
 */
class Authenticator extends Nette\Object implements Security\IAuthenticator
{
	/** @var Nette\Database\Connection */
	private $users;



	public function __construct(UserRepository $users)
	{
		$this->users = $users;
	}



	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($nickname, $heslo) = $credentials;
		$row = $this->users->findByName($nickname);

		if (!$row) {
			throw new Security\AuthenticationException("Používateľ '$nickname' nebol nájdený!", self::IDENTITY_NOT_FOUND);
		}

		if ($row->Heslo !== self::calculateHash($heslo, $row->Heslo)) {
			throw new Security\AuthenticationException("Zlé heslo!", self::INVALID_CREDENTIAL);
		}

		unset($row->Heslo);
		return new Security\Identity($row->id_p, NULL, $row->toArray());
	}



	/**
	 * Computes salted password hash.
	 * @param  string
	 * @return string
	 */
	public static function calculateHash($password, $salt = NULL)
	{
		return crypt($password, $salt ?: '$2a$07$' . Strings::random(22));
	}

}
