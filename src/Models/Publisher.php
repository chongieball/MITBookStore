<?php

namespace MBS\Models;

class Publisher extends BaseModel
{
    protected $table = 'publisher';
    protected $column = ['`id`, `name`, `update_at`, `create_at`, `deleted`'];

}
