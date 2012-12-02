<?php
namespace Evspot;

/**
 * Tabulka pouzivatel
 */
class RateRepository extends Repository
{
  /* Vyhladanie sadzby podla popisu */
	public function findByDesc($popis)
	{
    		return $this->findAll('sadzba')->where('Popis', $popis)->fetch();
	}	

	/* Vyhladanie sadzby podla id */
	public function findById($id)
	{
    		return $this->findAll('sadzba')->where('id_s', $id)->fetch();
	}	


	/* Pridanie novej sadzby vlozenim do tabulky DB */
	public function addRate($values)
	{
		return $this->getTable('sadzba')->insert(array(
			'Popis' => $values->popis,
			'Cena' => $values->cena,
		));
	}



}