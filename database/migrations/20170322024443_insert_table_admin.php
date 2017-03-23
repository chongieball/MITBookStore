<?php

use Phinx\Migration\AbstractMigration;

class InsertTableAdmin extends AbstractMigration
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
    public function up()
    {
        $rows = [
            [
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT)
            ],
            [
                'username' => 'admin2',
                'password' => password_hash('admin2', PASSWORD_DEFAULT)
            ]
        ];

        $this->insert('admin', $rows);
    }
}
