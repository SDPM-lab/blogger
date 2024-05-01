<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MemberAndTodoConstructionCaller extends Seeder
{
    public function run()
    {
        // Call the Memeber and Todolist Construction seeder.
        $this->call('MembersConstructionSeeder');
        $this->call('TodoListsConstructionSeeder');
    }
}
