<?php

namespace App\Controllers\RenderView\V1;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;

class MembersViewController extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    /**
     * return login page.
     *
     * @return void
     */
    public function loginPage()
    {
        if ($this->session->get("user") !== null) {
            return redirect()->to(base_url("/todoList"));
        } else {
            return view('login/loginPage');
        }
    }

    /**
     * return register page.
     *
     * @return void
     */
    public function registerPage()
    {
        if ($this->session->get("user") !== null) {
            return redirect()->to(base_url("/todoList"));
        } else {
            return view('login/registerPage');
        }
    }
}
