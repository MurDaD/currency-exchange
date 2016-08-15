<?php

use Phinx\Migration\AbstractMigration;

class CreateCurrenciesTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('currencies');
        $table->addColumn('bank', 'string', array('limit' => 32))
            ->addColumn('currency', 'string', array('limit' => 40))
            ->addColumn('sell', 'float', array('limit' => 6))
            ->addColumn('buy', 'float', array('limit' => 6))
            ->addColumn('added', 'datetime')
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
