<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
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
    public function signIn()
    {
        // Get login data from request.
        $loginData = $this->request->getJSON();

        $account   = $loginData->account ?? null;
        $password  = $loginData->password ?? null;

        // Check if account and password is correct.
        if ($account === null || $password === null) {
            return $this->fail("Sign in data is not found.", 404);
        }

        if ($account === " " || $password === " ") {
            return $this->fail("Sign in data is not found.", 404);
        }
        
        // Check if account and password is correct.
        $userData = $this->membersModel->where([
            "m_account"  => $account,
            "m_password" => sha1($password),
        ])->first();

        // If not, return fail response.
        if ($userData === null) {
            return $this->fail("Login fail.", 403);
        } else {
            // Re-define $userData array data to store into session.
            $userData = [
                'account' => $userData["m_account"],
                'name'    => $userData["m_name"],
                'key'     => $userData["m_key"]
            ];

            $this->session->set("user", $userData);

            return $this->respond([
                "msg"  => "Loin success.",
                "data" => $userData,
            ]);
        }
    }

    /**
     * Sing up the user data into database.
     *
     * @return void
     */
    public function signUp()
    {
        // Get signup data from request.
        $signupData = $this->request->getJSON();
        $account    = $signupData["account"];
        $password   = $signupData["password"];
        $name       = $signupData["name"];

        // Check if account and password is correct.
        if ($account === null || $password === null || $name === null) {
            return $this->fail("Sign in data is not found.", 404);
        }

        if ($account === " " || $password === " " || $name === " ") {
            return $this->fail("Sign in data is not found.", 404);
        }
        
        //Insert data to database.
        $userData = $this->membersModel->insert([
            "m_account"  => $account,
            "m_password" => sha1($password),
            "m_name"     => $name,
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
        $this->session->destroy("user");

        return redirect()->to(base_url("/"));
    }
}
