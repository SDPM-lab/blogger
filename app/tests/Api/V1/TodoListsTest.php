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
        $createData = [
            "title"     => "Example Title",
            "content"   => "Example Content",
        ];

        $todoListsModel = new TodoListsModel();

        $now = date("Y-m-d H:i:s");

        $createdKey = $todoListsModel->insert([
            "t_title"    => $createData["title"],
            "t_content"  => $createData["content"],
            "m_key"      => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $this->assertEquals(1, $createdKey);

        $createSecondData = [
            "title"     => "Example Title 2",
            "content"   => "Example Content 2",
        ];

        $createdSecondKey = $todoListsModel->insert([
            "t_title"   => $createSecondData["title"],
            "t_content" => $createSecondData["content"],
            "m_key"     => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $this->assertEquals(2, $createdSecondKey);

        $results = $this->withSession($this->sessionData)
                        ->get("api/v1/todo");

        $returnData = json_decode($results->getJSON());

        $excepted = [
            [
                "t_key"      => "1",
                "t_title"    => "Example Title",
                "t_content"  => "Example Content",
                "m_key"      => "1",
                "created_at" => $now,
                "updated_at" => $now,
                "deleted_at" => null
            ],
            [
                "t_key"      => "2",
                "t_title"    => "Example Title 2",
                "t_content"  => "Example Content 2",
                "m_key"      => "1",
                "created_at" => $now,
                "updated_at" => $now,
                "deleted_at" => null
            ]
        ];

        $this->assertEquals($excepted[0], (array)$returnData->data[0]);
        $this->assertEquals($excepted[1], (array)$returnData->data[1]);
    }

    public function testShowSingleDataSuccessfully()
    {
        $createData = [
            "title"     => "Example Title",
            "content"   => "Example Content",
        ];

        $todoListsModel = new TodoListsModel();

        $now = date("Y-m-d H:i:s");

        $createdKey = $todoListsModel->insert([
            "t_title"    => $createData["title"],
            "t_content"  => $createData["content"],
            "m_key"      => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $this->assertEquals(1, $createdKey);

        $createSecondData = [
            "title"     => "Example Title 2",
            "content"   => "Example Content 2",
        ];

        $createdSecondKey = $todoListsModel->insert([
            "t_title"   => $createSecondData["title"],
            "t_content" => $createSecondData["content"],
            "m_key"     => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $this->assertEquals(2, $createdSecondKey);

        $results = $this->withSession($this->sessionData)
                        ->get("api/v1/todo/2");

        $returnData = json_decode($results->getJSON());

        $excepted = [
            "key"      => "2",
            "title"    => "Example Title 2",
            "content"  => "Example Content 2"
        ];

        $this->assertEquals($excepted, (array)$returnData->data);
    }

    public function testUpdateTodoSuccessfully()
    {
        $createData = [
            "title"     => "Example Title",
            "content"   => "Example Content",
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

    public function FunctionName()
    {
        $createData = [
            "title"     => "Example Title",
            "content"   => "Example Content",
        ];

        $todoListsModel = new TodoListsModel();

        $now = date("Y-m-d H:i:s");

        $createdKey = $todoListsModel->insert([
            "t_title"    => $createData["title"],
            "t_content"  => $createData["content"],
            "m_key"      => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $this->assertEquals(1, $createdKey);

        $createSecondData = [
            "title"     => "Example Title 2",
            "content"   => "Example Content 2",
        ];

        $createdSecondKey = $todoListsModel->insert([
            "t_title"   => $createSecondData["title"],
            "t_content" => $createSecondData["content"],
            "m_key"     => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $this->assertEquals(2, $createdSecondKey);

        $results = $this->withSession($this->sessionData)
                        ->delete("api/v1/todo/2");

        $returnData = json_decode($results->getJSON());

        $excepted = [
            "msg" => "Delete successfully"
        ];

        $this->assertEquals($excepted, (array)$returnData->msg);

        $this->dontSeeInDatabase('TodoLists', [
            "t_title"   => $createSecondData["title"],
            "t_content" => $createSecondData["content"],
            "m_key"     => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
    }
}
