<?php

use Phinx\Migration\AbstractMigration;

class CreateBookTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $book = $this->table('book');
        $book->addColumn('publisher_id', 'integer', ['null' => true])
             ->addColumn('isbn', 'string')
             ->addColumn('title', 'string')
             ->addColumn('slug', 'string')
             ->addColumn('description', 'string')
             ->addColumn('publish_year', 'year')
             ->addColumn('total_page', 'integer')
             ->addColumn('synopsis', 'text')
             ->addColumn('images', 'string')
             ->addColumn('price', 'integer')
             ->addColumn('stock', 'integer')
             ->addColumn('update_at', 'timestamp')
             ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
             ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0])
             ->addIndex(['isbn', 'title', 'publish_year', 'slug'])
             ->addForeignKey('publisher_id', 'publisher', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
             ->create();
    }
}
