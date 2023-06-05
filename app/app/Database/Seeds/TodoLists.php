<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TodoLists extends Seeder
{
    public function run()
    {
        //seed some user todo data.
        $now   = date("Y-m-d H:i:s");

        $data = [
            [
                't_title'    => 'Example title',
                't_content' => 'Example content',
                'm_key' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('TodoLists')->insertBatch($data);
    }
}
