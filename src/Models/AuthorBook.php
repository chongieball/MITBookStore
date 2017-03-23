<?php

namespace MBS\Models;

class AuthorBook extends BaseModel
{
    protected $table = 'author_book';
    protected $column = '*';

    public function findAuthor($column, $value)
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

    public function add(array $data, $id)
    {
        $data = [
            'author_id'    => $data['author_id'],
            'book_id'      => $id
        ];
        $this->create($data);
    }
}
