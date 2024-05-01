<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MembersTableConstruction extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'm_key'           => [
                'type'           => 'INT',
                'constraint'     => 5,
                'auto_increment' => true,
                'unsigned'       => true
            ],
            'm_account'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'unique'         => true,
                'null'           => false
            ],
            'm_password'      => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false
            ],
            'm_name'           => [
                'type'           => 'VARCHAR',
                'constraint'     => 15,
                'null'           => false
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

        $this->forge->addKey('m_key', true);
        $this->forge->createTable('Members');
    }

    public function down()
    {
        $this->forge->dropTable('Members');
    }
}
