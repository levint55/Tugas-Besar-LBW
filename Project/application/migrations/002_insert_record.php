<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_insert_record extends CI_Migration {

        public function up()
        {
            $this->load->database();
            $records = array(
                array(
                    'blog_title' => 'my title',
                    'blog_description' => 'description'
                ),
                array(
                    'blog_title' => 'my title2',
                    'blog_description' => 'description2'
                )
                );
            $this->db->insert_batch('blog', $records);
        }

        public function down()
        {
            
        }
}