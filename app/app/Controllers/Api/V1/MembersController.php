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

    /**
     * Do login action.
     *
     * @return void
     */
    public function doLogin()
    {
        // Get login data from request.
        $loginData = $this->request->getJSON();
        $account   = $loginData["account"];
        $password  = $loginData["password"];
        
        // Check if account and password is correct.
        $userData = $this->membersModel->where([
            "account"  => $account,
            "password" => sha1($password),
        ])->first();

        // If not, return fail response.
        if ($userData === null) {
            return $this->failNotFound("Login fail.");
        } else {
            // Remove password in $userData array and store in session.
            unset($userData["password"]);
            
            $this->session->set("user", $userData);

            return $this->respond([
                "msg" => "Loin success."
            ]);
        }
    }

    /**
     * Sing up the user data into database.
     *
     * @return void
     */
    public function signup()
    {
        // Get signup data from request.
        $signupData = $this->request->getJSON();
        $account    = $signupData["account"];
        $password   = $signupData["password"];
        $name       = $signupData["name"];
        
        //Insert data to database.
        $userData = $this->membersModel->insert([
            "account"  => $account,
            "password" => sha1($password),
            "name"     => $name,
            "created"  => date("Y-m-d H:i:s"),
            "updated"  => date("Y-m-d H:i:s"),
        ]);

        // If not, return fail response.
        if ($userData === null) {
            return $this->fail("Signup fail.");
        } else {
            return $this->respond([
                "msg" => "Signup success.",
            ]);
        }
    }

    /**
     * Do logout action.
     *
     * @return void
     */
    public function logout()
    {
        //Destroy session and redirect to login page.
        $this->session->destroy();

        return redirect()->to(base_url("/"));
    }
}
