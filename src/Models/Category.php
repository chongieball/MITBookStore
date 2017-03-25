<?php

namespace MBS\Models;

class Category extends BaseModel
{
    protected $table = 'category';
    protected $column = ['id', 'name', 'create_at', 'update_at', 'deleted'];

    public function showCategoryBook($bookId)
    {
        $param = ':book_id';
        $cb = 'category_book';
        $b = 'book';
        $this->qb->select($this->column[1])
                 ->from($this->table, 'c')
                 ->join('c', $cb, 'cb', $this->column[0]. ' = cb.category_id')
                 ->join('c', 'book', 'b', 'cb.book_id = b.id')
                 ->where('cb.book_id = '. $param)
                 ->setParameter($param, $bookId);
                 // echo $this->qb->getSQL();
        $execute = $this->qb->execute();
        return $execute->fetchAll();
    }

}
