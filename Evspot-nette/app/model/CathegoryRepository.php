<?php
namespace Evspot;

/**
 * Tabulka kategoria
 */
class CathegoryRepository extends Repository
{
  /* Vyhladanie kategorie podla nazvu */
	public function findByName($nazov)
	{
    		return $this->findAll('kategoria')->where('Nazov', $nazov)->fetch();
	}	

	/* Vyhladanie kategorie podla Id */
	public function findById($id)
	{
    		return $this->findAll('kategoria')->where('id_kat', $id)->fetch();
	}	

  /* Vyhladanie kategorie podla Id */
	public function countCath()
	{
    		return $this->findAll('kategoria')->count('*');
	}

	/* Pridanie novej kategorie vlozenim do tabulky DB */
	public function addCathegory($values)
	{
		return $this->getTable('kategoria')->insert(array(
			'Nazov' => $values->nazov,
		));
	}

  /* Vymazanie kategorie podla Id_kategorie */
	public function deleteRow($id)
	{
    		return $this->findAll('kategoria')->where('id_kat', $id)->fetch()->delete();
	}
  
	/* Uprava udajov (UPDATE) kategorie v tabulke DB */
	public function updateCath($nazov,$id_kat)
	{
		return $this->findById($id_kat)->update(array(
			'Nazov' => $nazov,
		));
	}
	


}