<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_table extends CI_Migration
{

    public function up()
    {
        $this->create_organisation();
        $this->create_repository();
        $this->create_user();
        $this->create_language();
        $this->create_repo_lang();
        $this->create_repo_user();
    }

    public function down()
    {
        $this->dbforge->drop_table('repo_lang');
        $this->dbforge->drop_table('repo_user');
        $this->dbforge->drop_table('repository');
        $this->dbforge->drop_table('organisation');
        $this->dbforge->drop_table('user');
        $this->dbforge->drop_table('language');
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
            'full_name' => array(
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
            'fk_org' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'full_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'contributors_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'languages_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'size' => array(
                'type' => 'INT'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (fk_org) REFERENCES organisation(id)');
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
            'avatar_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user');
    }

    public function create_language()
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
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('language');
    }

    public function create_repo_lang()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'fk_repo' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'fk_lang' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'value' => array(
                'type' => 'INT'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (fk_repo) REFERENCES repository(id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (fk_lang) REFERENCES language(id)');
        $this->dbforge->create_table('repo_lang');
    }

    public function create_repo_user()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'fk_repo' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'fk_user' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'value' => array(
                'type' => 'INT'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (fk_repo) REFERENCES repository(id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (fk_user) REFERENCES user(id)');
        $this->dbforge->create_table('repo_user');
    }
}
