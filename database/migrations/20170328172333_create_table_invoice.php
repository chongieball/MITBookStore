<?php

use Phinx\Migration\AbstractMigration;

class CreateTableInvoice extends AbstractMigration
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
        $invoice = $this->table('invoice');
        $invoice->addColumn('order_id', 'integer')
                ->addColumn('code', 'string')
                ->addColumn('total_price', 'integer')
                ->addColumn('update_at', 'timestamp')
                ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('paid', 'integer', ['limit' => 1, 'default' => 0])
                ->addForeignKey('order_id', 'order', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
                ->create();
    }
}
