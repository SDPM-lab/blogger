<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\V1\MembersModel;
use App\Entities\MembersEntity;

class UsersController_QueryBuilder extends BaseController
{
    use ResponseTrait;
    protected MembersModel $membersModel;
    protected $db;
    protected $builder;

    /**
     * Member model.
     * 
     *
     * @var MembersModel
     */
    public function __construct()
    {
        $this->membersModel = new MembersModel();
        $this->db = \Config\Database::connect();
        if (!$this->db->connect()) {
            die('Database connection failed.');
        }
        $this->builder = $this->db->table('Members');
    }

    /**
     * [GET] /user/{key}
     *
     * @param integer|null $key
     * @return void
     */
    public function show(?int $key = null)
    {
        if ($key === null) {
            return $this->failNotFound("Enter the member key");
        }

        // Find the data from database using Query Builder.      
        $this->builder->where('m_key', $key);
        $user = $this->builder->get()->getRowArray();

        if ($user === null) {
            return $this->failNotFound("User is not found.");
        }

        // Define the return data structure.
        $returnData = [
            "account" => $user['m_account'],
            "name"    => $user['m_name']
        ];

        return $this->respond([
            "msg" => "success",
            "data" => $returnData
        ]);
    }


     /**
     * [PUT] /users/{key}
     *
     * @param integer|null $key
     * @return void
     */
    public function update(?int $key = null)
    {
        // Get the data from request
        $data = $this->request->getJSON(true);
        $password = $data['password'] ?? null;

        if ($key === null) {
            return $this->failNotFound("Key is not found.");
        }

        // Get the will update data.
        
        $this->builder->where('m_key', $key);
        $willUpdateData = $this->builder->get()->getRowArray();

        if ($willUpdateData === null) {
            return $this->failNotFound("This data is not found.");
        }
        if ($password !== null) {
            $willUpdateData["m_password"] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Do update action.
        $isUpdated = $this->builder->where('m_key', $key)->update($willUpdateData);

        if ($isUpdated === false) {
            return $this->fail("Update failed.");
        } else {
            return $this->respond([
                "msg" => "Update successfully"
            ]);
        }
    }

}
