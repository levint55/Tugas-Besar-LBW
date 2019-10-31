<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_table extends CI_Migration
{

    public function up()
    {
        $this->create_organisation();
        $this->create_repository();
        $this->create_user();
    }

    public function down()
    {
        $this->dbforge->drop_table('organisation');
        $this->dbforge->drop_table('repository');
        $this->dbforge->drop_table('user');
    }

    public function create_organisation()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'follower' => array(
                'type' => 'INT'
            ),
            'following' => array(
                'type' => 'INT'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('organisation');
    }

    public function create_repository()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'full_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'contributor_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'language_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'size' => array(
                'type' => 'INT'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('repository');
    }

    public function create_user()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'follower' => array(
                'type' => 'INT'
            ),
            'following' => array(
                'type' => 'INT'
            ),
            'avatar_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user');
    }
}
