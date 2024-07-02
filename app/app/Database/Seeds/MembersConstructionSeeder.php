<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MembersConstructionSeeder extends Seeder
{
    public function run()
    {
        //seed some user fake data.
        $now   = date("Y-m-d H:i:s");

        $data = [
            [
                'm_name'    => 'Example User',
                'm_account' => 'example_account',
                'm_password' => password_hash("example_password", PASSWORD_DEFAULT),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('Members')->insertBatch($data);
    }
}
