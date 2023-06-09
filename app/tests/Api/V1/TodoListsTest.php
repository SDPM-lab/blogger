<?php

use App\Models\V1\TodoListsModel;
use Tests\Support\DatabaseTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class TodoListsTest extends DatabaseTestCase
{
    use FeatureTestTrait;

    public function setUp(): void
    {
        parent::setUp();

        //seed some user fake data.
        $now   = date("Y-m-d H:i:s");

        $data = [
            [
                'm_name'    => 'Example User',
                'm_account' => 'example_account',
                'm_password' => sha1('example_password'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('Members')->insertBatch($data);

        $userLoginData = [
            "account"  => "example_account",
            "password" => "example_password",
            "key"      => 1
        ];

        session('user', $userLoginData);

        var_dump(session()->get('user'));

    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->table('Members')->emptyTable('Members');
        $this->db->table('TodoLists')->emptyTable('TodoLists');
        $this->db->query("ALTER TABLE Members AUTO_INCREMENT = 1");
        $this->db->query("ALTER TABLE TodoLists AUTO_INCREMENT = 1");
    }

    public function testCreateTodoSuccessfully()
    {
        

        $createData = [
            "title"     => "Example Title 2",
            "content"   => "Example Content 2",
        ];

        // $results = $this->withBodyFormat('json')
        //                 ->post("api/v1/todo", $createData);

        // var_dump($results->getJSON());

        // $results->assertStatus(200);

        // $returnData = json_decode($results->getJSON());

        // $this->assertEquals(2, $returnData->data);
    }
}
