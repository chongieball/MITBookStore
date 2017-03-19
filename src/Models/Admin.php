<?php

namespace MBS\Models;

class Admin extends BaseModel
{
    protected $table = 'admin';

    public function add(array $data)
    {
        $data = [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ];

        $this->create($data);
    }
}


 ?>
