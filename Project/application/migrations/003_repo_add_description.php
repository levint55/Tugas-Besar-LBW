<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_repo_add_description extends CI_Migration
{

    public function up()
    {
        $this->alter_table_repository();
    }

    public function down()
    {
        
    }

    public function alter_table_repository()
    {
        $fields = array(
            'description' => array('type' => 'TEXT', 'null' => True)
        );
        $this->dbforge->add_column('repository', $fields);
    }
}
