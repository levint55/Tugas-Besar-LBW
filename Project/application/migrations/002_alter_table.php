<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_alter_table extends CI_Migration
{

    public function up()
    {
        $this->alter_table_organisation();
    }

    public function down()
    {
        
    }

    public function alter_table_organisation()
    {
        $fields = array(
            'full_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => True,
        ));
        $this->dbforge->modify_column('organisation', $fields);
    }
}
