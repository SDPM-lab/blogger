<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\V1\MembersModel;

class MembersController extends BaseController
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

    public function doLogin()
    {
        $loginData = $this->request->getJSON();
        $account   = $loginData["account"];
        $password  = $loginData["password"];
        
        $this->membersModel->where([
            "account"  => $account,
            "password" => $password,
        ])->first();

    }
}
