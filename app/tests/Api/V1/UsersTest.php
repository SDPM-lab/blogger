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

    public function setUp(): void
    {
        parent::setUp();

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
        $this->db->query("ALTER TABLE Members AUTO_INCREMENT = 1");
    }

    public function testShowUserSuccessfully_orm(): void
    {
        $createData = [
            "m_account"  => "example_account",
            "m_password" => password_hash("example_password", PASSWORD_DEFAULT),
            "m_name"     => "Example User",
            "m_key"      => 1,
        ];

        $membersModel = new MembersModel();

        $createdKey = $membersModel->insert($createData);

        $this->assertEquals(1, $createdKey);

        $results = $this->withSession($this->sessionData)
                        ->get("api/v1/users_orm/1");

        $returnData = json_decode($results->getJSON());

        $expected = [
            "account" => "example_account",
            "name"    => "Example User",
        ];

        $this->assertEquals($expected, (array)$returnData->data);
    }

    public function testUpdateUserSuccessfully_orm()
    {
        $createData = [
            "m_account"  => "example_account",
            "m_password" => password_hash("example_password", PASSWORD_DEFAULT),
            "m_name"     => "Example User",
            "m_key"      => 1,
        ];

        $membersModel = new MembersModel();

        $createdKey = $membersModel->insert($createData);

        $this->assertEquals(1, $createdKey);

        $updatedData = [
            "password" => "modified_password"
        ];

        $results = $this->withSession($this->sessionData)
                        ->withBodyFormat('json')
                        ->put("api/v1/users_orm/1", $updatedData);

        $results->assertStatus(200);

        // 從資料庫中獲取更新後的用戶資料
        $updatedUser = $membersModel->find(1);

        // 使用 password_verify 檢查更新後的密碼是否正確加密
        $this->assertTrue(password_verify("modified_password", $updatedUser->m_password));

        $returnData = json_decode($results->getJSON());

        $expected = [
            "msg" => "Update successfully",
            "res" => true
        ];

        $this->assertEquals($expected, (array)$returnData);
    }

    public function testShowUserSuccessfully_query_builder(): void
    {
        $createData = [
            "m_account"  => "example_account",
            "m_password" => password_hash("example_password", PASSWORD_DEFAULT),
            "m_name"     => "Example User",
            "m_key"      => 1,
        ];

        $membersModel = new MembersModel();

        $createdKey = $membersModel->insert($createData);

        $this->assertEquals(1, $createdKey);

        $results = $this->withSession($this->sessionData)
                        ->get("api/v1/users_query_builder/1");

        $returnData = json_decode($results->getJSON());

        $expected = [
            "account" => "example_account",
            "name"    => "Example User",
        ];

        $this->assertEquals($expected, (array)$returnData->data);
    }

    public function testUpdateUserSuccessfully_query_builder()
    {
        $createData = [
            "m_account"  => "example_account",
            "m_password" => password_hash("example_password", PASSWORD_DEFAULT),
            "m_name"     => "Example User",
            "m_key"      => 1,
        ];

        $membersModel = new MembersModel();

        $createdKey = $membersModel->insert($createData);

        $this->assertEquals(1, $createdKey);

        $updatedData = [
            "password" => "modified_password"
        ];

        $results = $this->withSession($this->sessionData)
                        ->withBodyFormat('json')
                        ->put("api/v1/users_query_builder/1", $updatedData);

        $results->assertStatus(200);

        // 從資料庫中獲取更新後的用戶資料
        $updatedUser = $membersModel->find(1);

        // 使用 password_verify 檢查更新後的密碼是否正確加密
        $this->assertTrue(password_verify("modified_password", $updatedUser->m_password));

        $returnData = json_decode($results->getJSON());

        $expected = [
            "msg" => "Update successfully",
        ];

        $this->assertEquals($expected, (array)$returnData);
    }
}
