<?php

use Phinx\Seed\AbstractSeed;

class BookSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'title'         => 'Hujan',
                'description'   => 'Tentang Hujan',
                'image'         => '2.jpg',
                'price'         => 50000,
            ],
            [
                'title'         => 'Pulang',
                'description'   => 'Sudah Magrib',
                'image'         => '3.jpg',
                'price'         => 50000,
            ],
            [
                'title'         => 'Scrambled',
                'description'   => 'We are Scrambled!',
                'image'         => '1.jpg',
                'price'         => 50000,
            ],
        ];

        $book = $this->table('test_book');
        $book->insert($data)
             ->save();
    }
}
