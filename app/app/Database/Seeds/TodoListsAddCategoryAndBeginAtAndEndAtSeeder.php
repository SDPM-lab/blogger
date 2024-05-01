<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TodoListsAddCategoryAndBeginAtAndEndAtSeeder extends Seeder
{
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        $data = [
            't_category' => 'Work',
            't_begin_at' => $now,
            't_end_at'   => date('Y-m-d H:i:s', strtotime('+1 week'))
        ];

        $this->db->table('TodoLists')->update($data);
    }
}
