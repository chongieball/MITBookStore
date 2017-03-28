<?php

namespace MBS\Models;

abstract class BaseModel
{
	protected $table;
	protected $column;
	protected $db;
	protected $qb;

    public function __construct($db)
	{
        $this->db = $db;
        $this->qb = $db->createQueryBuilder();
	}

    public function getAll()
	{
        $this->qb
            ->select($this->column)
            ->from($this->table)
            ->where('deleted = 0');

        $result = $this->qb->execute();
        return $result->fetchAll();
	}

	//conditional find
	public function find($column, $value)
	{
		$param = ':'.$column;
		$this->qb
		     ->select($this->column)
			 ->from($this->table)
			 ->where($column . ' = '. $param)
			 ->setParameter($param, $value);
		$result = $this->qb->execute();
		return $result->fetch();
	}

	public function findNotDelete($column, $value)
	{
		$param = ':'.$column;
		$this->qb
		     ->select($this->column)
			 ->from($this->table)
			 ->where($column . ' = '. $param. ' AND deleted = 0')
			 ->setParameter($param, $value);
		$result = $this->qb->execute();
		return $result->fetch();
	}

	public function create(array $data)
	{
		$column = [];
		$paramData = [];
		foreach ($data as $key => $value) {
			$column[$key] = ':'.$key;
			$paramData[$key] = $value;
		}

		$this->qb->insert($this->table)
				->values($column)
				->setParameters($paramData)
				->execute();
	}

	//conditional edit
	public function update(array $data, $column, $value)
	{
	    $columns = [];
	    $paramData = [];
	    $this->qb->update($this->table);
	    foreach ($data as $key => $values) {
	    	$columns[$key] = ':'.$key;
	    	$paramData[$key] = $values;
	    	$this->qb->set($key, $columns[$key]);
	    }
	    $this->qb
	    	 ->where( $column.'='. $value)
	         ->setParameters($paramData);
	    return $this->qb->execute();
	}

	//conditional delete
	public function softDelete($column, $value)
	{
	    $this->qb
	    	 ->update($this->table)
	         ->set('deleted', 1)
	         ->where($column. '=' . $value)
	         ->execute();
	}

	public function showAll()
	{
	    $this->qb
	    	 ->select($this->column)
	         ->from($this->table);

	    $result = $this->qb->execute();
	    return $result->fetchAll();
	}

	public function restore($id)
	{
	    $this->qb
	    	 ->update($this->table)
	         ->set('deleted', 0)
	         ->where('id = ' . $id)
	         ->execute();
	}

	public function hardDelete($id)
	{
	    $this->qb
	    	 ->delete($this->table)
	         ->where('id = ' . $id)
	         ->execute();
	}

	public function getArchive()
	{
		$this->qb->select($this->column)
				 ->from($this->table)
				 ->where('deleted = 1');
		$result = $this->qb->execute();

		return $result->fetchAll();
	}
	
    public  function __destruct()
    {
    	$this->db->close();
    }
}