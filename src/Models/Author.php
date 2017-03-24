<?php

namespace MBS\Models;

class Author extends BaseModel
{
    protected $table = 'author';
    protected $column = ['`id`, `name`, `update_at`, `create_at`, `deleted`'];

    public function allJoin($deleted)
    {
        $param = ':deleted';
        $this->db->select($this->column)
        ->from($this->table)
        ->where('deleted ='.$param)
        ->setParameter($param, $deleted);
        $result = $this->db->execute();
        return $result->fetchAll();
    }

}
