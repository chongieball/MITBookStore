<?php

namespace MBS\Models;

class Invoice extends BaseModel
{
    protected $table = 'invoice';
    protected $column = ['id', 'order_id', 'code', 'total_price', 'create_at', 'update_at', 'paid'];

    public function add(array $data)
    {
    	$this->create($data);

    	return $this->db->lastInsertId();
    }
}
