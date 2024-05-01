<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TodoListsAddCategoryAndBeginAtAndEndAt extends Migration
{
    public function up()
    {
        // Add Category, BeginAt and EndAt field to TodoLists table.
        $this->forge->addColumn('TodoLists', [
            't_category' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true
            ],
            't_begin_at' => [
                'type'           => 'datetime',
                'null'           => true
            ],
            't_end_at' => [
                'type'           => 'datetime',
                'null'           => true
            ]
        ]);
    }

    public function down()
    {
        // Drop Category, BeginAt and EndAt field from TodoLists table.
        $this->forge->dropColumn('TodoLists', 't_category');
        $this->forge->dropColumn('TodoLists', 't_begin_at');
        $this->forge->dropColumn('TodoLists', 't_end_at');
    }
}
