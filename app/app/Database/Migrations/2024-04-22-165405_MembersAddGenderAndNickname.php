<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MembersAddGenderAndNickname extends Migration
{
    public function up()
    {
        // Add gender and nickname fields to members table.
        $this->forge->addColumn('Members', [
            'm_gender' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true
            ],
            'm_nickname' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true
            ]
        ]);
    }

    public function down()
    {
        // Drop gender and nickname fields from members table.
        $this->forge->dropColumn('Members', 'm_gender');
        $this->forge->dropColumn('Members', 'm_nickname');
    }
}
