<?php
namespace Evspot;
use Nette;

abstract class Repository extends Nette\Object
{
    /** @var Nette\Database\Connection */
    protected $connection;

    public function __construct(Nette\Database\Connection $db)
    {
        $this->connection = $db;
    }

    /**
     * 
     * @return Nette\Database\Table\Selection
     */
    protected function getTable($table)
    {
        return $this->connection->table($table);
    }

    /**
     * 
     * @return Nette\Database\Table\Selection
     */
    public function findAll($table)
    {
        return $this->getTable($table);
    }

    /**
     * 
     * @return Nette\Database\Table\Selection
     */
    public function findBy($table, array $by)
    {
        return $this->getTable($table)->where($by);
    }

}