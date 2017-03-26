<?php

namespace MBS\Models;

class CategoryBook extends BaseModel
{
    protected $table = 'category_book';
    protected $column = '*';

    public function findCategory($column, $value)
    {
        $param = ':'.$column;
        $this->db
             ->select($this->column)
             ->from($this->table)
             ->where($column . ' = '. $param)
             ->setParameter($param, $value);

        $result = $this->db->execute();

        return $result->fetchAll();
    }

    public function showCategoryBook($bookId)
    {
        $param = ':id';
        $this->db->select('c.name')
                 ->from($this->table, 'cb')
                 ->join('cb', 'book', 'b', 'cb.book_id = b.id')
                 ->join('cb', 'category', 'c', 'cb.category_id = c.id')
                 ->where('cb.book_id = '. $param)
                 ->setParameter($param, $bookId);
                 // echo $this->db->getSQL();
                 $result = $this->db->execute();
                 
                 return $result->fetchAll();
    }

    public function add(array $data, $id)
    {
        $data = [
            'category_id'    => $data['category_id'],
            'book_id'      => $id
        ];
        $this->create($data);
    }

}
