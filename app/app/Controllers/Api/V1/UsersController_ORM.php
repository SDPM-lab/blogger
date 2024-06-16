<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\V1\MembersModel;

class UsersController_ORM extends BaseController
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
    public function show($key = null)
    {
        $membersEntity = $this->membersModel->find($key);

        if ($membersEntity === null) {
            return $this->failNotFound("User not found.");
        }

        // Define the return data structure.
        $returnData = [
            "account" => $membersEntity->m_account,
            "name"    => $membersEntity->m_name
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
        $data = $this->request->getJSON(true);

        $membersEntity = $this->membersModel->find($key);

        if ($membersEntity === null) {
            return $this->failNotFound("User not found.");
        }

        // Verify m_password exists
        if (empty($data['m_password'])) {
            return $this->fail("Password data is not found.", 400);
        }

        if (isset($data['m_account'])) {
            $membersEntity->m_account = $data['m_account'];
        }
    
        if (isset($data['m_name'])) {
            $membersEntity->m_name = $data['m_name'];
        }

        // Do update action.
        $membersEntity->m_password = password_hash($data['m_password'], PASSWORD_DEFAULT);

        if($membersEntity->m_password == null){
            return $this->fail("Password data is not found.",400);
        }

        //Sava data.
        $result = $this->membersModel->save($membersEntity);

        if($result){
            return $this->respond([
                "msg" => "Success  updated",
                "res" => $result
            ]);
        }else{
            return $this->fail("Server Error",400);
        }
    }

}
