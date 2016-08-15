<?php

use Phinx\Migration\AbstractMigration;

class CreateCurrenciesTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('currencies');
        $table->addColumn('bank', 'string', array('limit' => 32))->addIndex(array('bank'))
            ->addColumn('currency', 'string', array('limit' => 40))->addIndex(array('currency'))
            ->addColumn('sell', 'float', array('limit' => 6))
            ->addColumn('buy', 'float', array('limit' => 6))
            ->addColumn('added', 'datetime')->addIndex(array('added'))
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('currencies');
    }
}
