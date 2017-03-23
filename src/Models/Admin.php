<?php

namespace MBS\Models;

class Admin extends BaseModel
{
    protected $table = 'admin';
    protected $column = ['id', 'username', 'password'];

    public function setPassword($password, $id)
    {
        $data = [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        // $this->update($);
    }
}


 ?>
