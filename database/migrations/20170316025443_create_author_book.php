<?php

use Phinx\Migration\AbstractMigration;

class CreateAuthorBook extends AbstractMigration
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
        $authorBook = $this->table('author_book', ['id' => false]);
        $authorBook->addColumn('author_id', 'integer')
                   ->addColumn('book_id', 'integer')
                   ->addForeignKey('author_id', 'author', 'id')
                   ->addForeignKey('book_id', 'book', 'id')
                   ->create();
    }
}
