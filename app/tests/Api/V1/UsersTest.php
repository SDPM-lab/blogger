<?php

use App\Models\V1\MembersModel;
use Tests\Support\DatabaseTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class UsersTest extends DatabaseTestCase
{
    use FeatureTestTrait;

    /**
     * Session Data.
     *
     * @var array
     */
    protected array $sessionData;

    // For Seeds
    protected $seedOnce = false;
    protected $seed     = 'Members';
    protected $basePath = APPPATH . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->db->table('Members')->emptyTable('Members');
        $this->db->query("ALTER TABLE Members AUTO_INCREMENT = 1");
    }

    public function testDatabase()
    {
        $membersModel = new MembersModel();
        
        // Check whether database seed and migrate successfully.
        $data = $membersModel->findAll();

        $this->assertNotEmpty($data);
    }

    public function testShowUserSuccessfully(): void
    {
        $createData = [
            "account"  => "example_account",
            "password" => "example_password",
            "name"     => "Example User"
        ];

        $membersModel = new MembersModel();

        $createdKey = $membersModel->insert([
            "m_account"  => $createData["account"],
            "m_password" => sha1($createData["password"]),
            "m_name"     => $createData["name"],
            "m_key"      => 1,
        ]);

        $this->assertEquals(1, $createdKey);

        $results = $this->withSession($this->sessionData)
                        ->get("api/v1/users/1");

        $returnData = json_decode($results->getJSON());

        $excepted = [
            "account" => "example_account",
            "name"    => "Example User",
        ];

        $this->assertEquals($excepted, (array)$returnData->data);
    }

    public function testUpdateUserSuccessfully()
    {
        $createData = [
            "account"  => "example_account",
            "password" => "example_password",
            "name"     => "Example User"
        ];

        $membersModel = new MembersModel();

        $createdKey = $membersModel->insert([
            "m_account"  => $createData["account"],
            "m_password" => sha1($createData["password"]),
            "m_name"     => $createData["name"],
            "m_key"      => 1,
        ]);

        $this->assertEquals(1, $createdKey);

        $this->seeInDatabase('Members', [
            "m_account"  => $createData["account"],
            "m_password" => $createData["password"],
            "m_name"     => $createData["name"],
            "m_key"      => 1
        ]);

        $updatedData = [
            "password" => "modified_password",
        ];

        $results = $this->withSession($this->sessionData)
                        ->withBodyFormat('json')
                        ->put("api/v1/users/1", $updatedData);

        $results->assertStatus(200);

        $this->seeInDatabase('Members', [
            "m_password" => $updatedData["password"],
        ]);

        $returnData = json_decode($results->getJSON());

        $excepted = [
            "msg" => "Update successfully"
        ];

        $this->assertEquals($excepted, (array)$returnData);
    }
}
