<?php 

namespace MBS\Models;

class Book extends BaseModel
{
	protected $table = 'test_book';
	protected $column = ['id', 'title', 'description', 'image', 'price', 'stock'];

	public function getIdWhereIn($ids)
	{
		if (!empty($ids)) {
			$this->db->select($this->column)
					 ->from($this->table)
					 ->where('id IN (' . implode(',', $ids) . ')');
			$result = $this->db->execute();
			return $result->fetchAll();
		}
	}
}