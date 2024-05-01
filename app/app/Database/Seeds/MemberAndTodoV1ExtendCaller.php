<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MemberAndTodoV1ExtendCaller extends Seeder
{
    public function run()
    {
        // Call the Memeber and Todolist Construction seeder.
        $this->call('MembersAddGenderAndNicknameSeeder');
        $this->call('TodoListsAddCategoryAndBeginAtAndEndAtSeeder');
    }
}
