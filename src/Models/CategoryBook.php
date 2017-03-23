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

    public function add(array $data, $id)
    {
        $data = [
            'category_id'    => $data['category_id'],
            'book_id'      => $id
        ];
        $this->create($data);
    }

}
