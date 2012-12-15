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

	/* Vyhladanie sadzby podla id sadzby*/
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

  /* Vymazanie kategorie podla Id_sadzby */
	public function deleteRow($id)
	{
    		return $this->findAll('sadzba')->where('id_s', $id)->fetch()->delete();
	}


  /* Uprava udajov (UPDATE) sadzby v tabulke DB */
	public function updateRate($popis,$cena,$id_s)
	{
		return $this->findById($id_s)->update(array(
			'Popis' => $popis,
      'Cena' => $cena,
		));
	}
  
}