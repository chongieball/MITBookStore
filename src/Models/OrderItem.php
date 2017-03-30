<?php

namespace MBS\Models;

class OrderItem extends BaseModel
{
    protected $table = 'order_item';
    protected $column = ['order_id', 'book_id', 'qty'];

    public function add(array $data)
    {
    	$columns = [];
    	$values = [];

    	$this->qb->insert($this->table);

    	foreach ($data as $dataKey => $dataValue) {
    		foreach ($dataValue as $key => $val) {
    			$columns[$key] = ':'. $key;
    			$values[$key] = $val; 
    		}

    		$this->qb->values($columns)
    				 ->setParameters($values)
    				 ->execute();
    	}
    }
}
