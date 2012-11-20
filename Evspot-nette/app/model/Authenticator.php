<?php

use Nette\Security,
	Nette\Utils\Strings;


/**
 * Users authenticator.
 */
class Authenticator extends Nette\Object implements Security\IAuthenticator
{
	/** @var Nette\Database\Connection */
	private $users;



	public function __construct(EVSPOT\UserRepository $users)
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
		list($username, $password) = $credentials;
		$row = $this->users->findByName($username);

		if (!$row) {
			throw new Security\AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
		}

		if ($row->heslo !== self::calculateHash($password, $row->heslo)) {
			throw new Security\AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
		}

		unset($row->heslo);
		return new Security\Identity($row->id_p, NULL, $row->toArray());
	}



	/**
	 * Computes salted password hash.
	 * @param  string
	 * @return string
	 */
	public static function calculateHash($password, $salt = NULL)
	{
		if ($salt === null) { 
			$salt = '$2a$07$' . Nette\Utils\Strings::random(32) . '$';
		}
		return crypt($password, $salt);
	}

}
