<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MembersAddGenderAndNicknameSeeder extends Seeder
{
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        $data = [
            'm_gender'   => 'male',
            'm_nickname' => 'example_nick',
            'updated_at' => $now
        ];

        $this->db->table('Members')->update($data);
    }

}
