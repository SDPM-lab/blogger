<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\V1\MembersModel;

class UsersController extends BaseController
{
    use ResponseTrait;

    /**
     * Member model.
     * 
     *
     * @var MembersModel
     */
    protected MembersModel $membersModel;

    public function __construct()
    {
        $this->membersModel = new MembersModel();
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
            return $this->failNotFound("Enter the the member key");
        }

        // Find the data from database.
        $user = $this-> membersModel->where(
            "m_key",
            $this->userData["key"]
        )->find($key);

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
        // Get the data from request.
        $data     = $this->request->getJSON();
        $password = $data->password ?? null;

        if ($key === null) {
            return $this->failNotFound("Key is not found.");
        }

        // Get the will update data.
        $willUpdateData = $this-> membersModel->where(
            "m_key",
            $this->userData["key"]
        )->find($key);

        if ($willUpdateData === null) {
            return $this->failNotFound("This data is not found.");
        }

        if ($password !== null) {
            $willUpdateData["m_password"] = sha1($password);
        }

        // Do update action.
        $isUpdated = $this->membersModel->update($key, $willUpdateData);

        if ($isUpdated === false) {
            return $this->fail("Update failed.");
        } else {
            return $this->respond([
                "msg" => "Update successfully"
            ]);
        }
        
    }

}
