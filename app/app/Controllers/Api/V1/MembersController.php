<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\V1\MembersModel;
use App\Entities\MembersEntity;

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

        // Find user by account
        $userData = $this->membersModel->where("m_account", $account)->first();

        // If user not found or password does not match, return fail response.
        if ($userData === null || !password_verify($password, $userData->m_password)) {
            return $this->fail("Login fail.", 403);
        } else {
            // Re-define $userData array data to store into session.
            $userSessionData = [
                'account' => $userData->m_account,
                'name'    => $userData->m_name,
                'key'     => $userData->m_key,
            ];

            $this->session->set("user", $userSessionData);

            return $this->respond([
                "msg"  => "Login success.",
                "data" => $userSessionData,
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
        $account    = $signupData->account  ?? null;
        $password   = $signupData->password ?? null;
        $name       = $signupData->name     ?? null;

        // Check if account and password is correct.
        if ($account === null || $password === null || $name === null) {
            return $this->fail("Sign up data is not found.", 404);
        }

        if ($account === " " || $password === " " || $name === " ") {
            return $this->fail("Sign up data is not found.", 404);
        }

        if ($this->membersModel->where(["m_account" => $account])->first() !== null) {
            return $this->fail("Account already exists.", 403);
        }
        
        // Insert data to database using entity.
        $membersEntity = new MembersEntity();
        $membersEntity->m_account  = $account;
        $membersEntity->m_password = password_hash($password, PASSWORD_DEFAULT);
        $membersEntity->m_name     = $name;

        // If not, return fail response.
        $result = $this->membersModel->save($membersEntity);

        if ($result) {
            return $this->respond([
                "msg"  => "Signup success.",
                "data" => [
                    "account" => $account,
                    "name"    => $name,
                ]
            ]);
        } else {
            return $this->fail("Signup fail.");
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
