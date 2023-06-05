<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TodoLists extends Migration
{
    public function up()
    {
        $this->forge->addField([

            't_key'           => [
                'type'           => 'INT',
                'constraint'     => 5,
                'auto_increment' => true,
                'unsigned'       => true
            ],
            't_title'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false
            ],
            't_content'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 500,
                'null'           => false
            ],
            'm_key'           => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'comment'        => "Member_key from Members table",
            ],
            "created_at"      => [
                'type'           => 'datetime'
            ],
            "updated_at"      => [
                'type'           => 'datetime'
            ],
            "deleted_at"      => [
                'type'           => 'datetime',
                'null'           => true
            ]
        ]);

        $this->forge->addKey('t_key', true);
        $this->forge->addForeignKey('m_key', 'Members', 'm_key', 'CASCADE', 'CASCADE');
        $this->forge->createTable('TodoLists');
    }

    public function down()
    {
        //
    }
}
