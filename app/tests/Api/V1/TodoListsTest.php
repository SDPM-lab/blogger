<?php

use App\Models\V1\TodoListsModel;
use Tests\Support\DatabaseTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class TodoListsTest extends DatabaseTestCase
{
    use FeatureTestTrait;

    /**
     * Session Data.
     *
     * @var array
     */
    protected array $sessionData;

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

        $this->sessionData = [
            "user" => [
                "account"  => "example_account",
                'name'     => 'Example User',
                "key"      => 1
            ]
        ];
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->table('Members')->emptyTable('Members');
        $this->db->table('TodoLists')->emptyTable('TodoLists');
        $this->db->query("ALTER TABLE Members AUTO_INCREMENT = 1");
        $this->db->query("ALTER TABLE TodoLists AUTO_INCREMENT = 1");

        session()->destroy("user");
    }

    public function testCreateTodoSuccessfully()
    {
        $createData = [
            "title"     => "Example Title",
            "content"   => "Example Content",
        ];

        $results = $this->withSession($this->sessionData)
                        ->withBodyFormat('json')
                        ->post("api/v1/todo", $createData);

        $results->assertStatus(200);

        $returnData = json_decode($results->getJSON());

        $this->assertEquals(1, $returnData->data);

        $this->seeInDatabase('TodoLists', [
            "t_title"   => $createData["title"],
            "t_content" => $createData["content"],
        ]);
    }

    public function testShowAllDataSuccessfully()
    {
        # code...
    }

    public function testUpdateTodoSuccessfully()
    {
        $createData = [
            "title"     => "Example Title 2",
            "content"   => "Example Content 2",
        ];

        $todoListsModel = new TodoListsModel();

        $createdKey = $todoListsModel->insert([
            "t_title"   => $createData["title"],
            "t_content" => $createData["content"],
            "m_key"     => 1,
        ]);

        $this->assertEquals(1, $createdKey);

        $this->seeInDatabase('TodoLists', [
            "t_title"   => $createData["title"],
            "t_content" => $createData["content"],
            "m_key"     => 1
        ]);

        $updatedData = [
            "title"     => "Example Title 2",
            "content"   => "Example Content 2",
        ];

        $results = $this->withSession($this->sessionData)
                        ->withBodyFormat('json')
                        ->put("api/v1/todo/1", $updatedData);

        $results->assertStatus(200);

        $this->seeInDatabase('TodoLists', [
            "t_title"   => $updatedData["title"],
            "t_content" => $updatedData["content"],
        ]);

        $returnData = json_decode($results->getJSON());

        $excepted = [
            "msg" => "Update successfully"
        ];

        $this->assertEquals($excepted, (array)$returnData);
    }
}
