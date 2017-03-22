<?php

namespace Chongieball\Models;

abstract class BaseModel
{
	protected $table;
	protected $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getAll()
	{
		$this->db
			 ->select('*')
			 ->from($this->table);

		$result = $this->db->execute();

		return $result->fetchAll();
	}

	//conditional find
	public function find($column, $value)
	{
		$param = ':'.$column;
		$this->db
			 ->select('*')
			 ->from($this->table)
			 ->where($column . ' = '. $param)
			 ->setParameter($param, $value);

		$result = $this->db->execute();

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
		$this->db->insert($this->table)
				->values($column)
				->setParameters($paramData)
				->execute();
	}

	public function updateData(array $data, $id)
    {
        $valuesColumn = [];
        $valuesData   = [];

        $this->db->update($this->table);

        foreach ($data as $dataKey => $dataValue) {

                $valuesColumn[$dataKey] = ':' .$dataKey;
                $valuesData[$dataKey]   = $dataValue;

                $this->db->set($dataKey, $valuesColumn[$dataKey]);

        }

        $this->db->setParameters($valuesData)
             ->where('id ='. $id)
             ->execute();
    }

}
