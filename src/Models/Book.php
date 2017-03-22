<?php 

namespace MBS\Models;

class Book extends BaseModel
{
	protected $table = 'test_book';
	protected $column = ['id', 'title', 'description', 'image', 'price'];

	public function getIdWhereIn($ids)
	{
		if (!empty($id)) {
			$this->db->select($this->column)
					 ->from($this->table)
					 ->where('id IN (' . implode(',', $ids) . ')');
			$result = $this->db->execute();
			return $result->fetchAll();
		}
	}
}