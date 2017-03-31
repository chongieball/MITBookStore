<?php

namespace MBS\Models;

class Order extends BaseModel
{
    protected $table = '`order`';
    protected $column = ['id', 'user_id', 'create_at'];
    private $showAll = ['o.id', 'o.create_at', 'o_i.qty', 'b.title', 'b.price',];

    public function add(array $data)
    {
    	$data = [
    		'user_id' => $data['user_id'],
    	];

    	$this->create($data);
    	return $this->db->lastInsertId();
    }

    // public function getOrderItem($order)
    // {
    // 	$this->qb->select()
    // }

    public function show($orderId)
    {
    	$param = ':order_id';
    	$user = 'user';
    	$orderItems = 'order_item';
    	$book = 'book';
    	$this->qb->select($this->showAll)
    			 ->from($this->table, 'o')
    			 ->join('o', $orderItems, 'o_i', 'o_i.order_id = '.$this->column[0])
    			 ->join('o_i', $book, 'b', 'o_i.book_id = b.id')
    			 ->where('o.id = '. $param)
    			 ->setParameter($param, $orderId);
    			 // echo $this->qb->getSQL();
    	$result = $this->qb->execute();
    	return $result->fetchAll();
    }
}
