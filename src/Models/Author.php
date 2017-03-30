<?php

namespace MBS\Models;

class Author extends BaseModel
{
    protected $table = 'author';
    protected $column = ['id', 'name', 'create_at', 'deleted'];

    public function showAuthorBook($bookId)
    {
        $param = ':book_id';
        $ab = 'author_book';
        $b = 'book';
        $this->qb->select($this->column[1])
                 ->from($this->table, 'a')
                 ->join('a', $ab, 'ab', $this->column[0]. ' = ab.author_id')
                 ->join('a', $b, 'b', 'ab.book_id = b.id')
                 ->where('ab.book_id = '. $param)
                 ->setParameter($param, $bookId);
                 // echo $this->qb->getSQL();
        $execute = $this->qb->execute();
        return $execute->fetchAll();
    }

}
