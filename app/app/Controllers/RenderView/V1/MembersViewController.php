<?php

namespace App\Controllers\RenderView\V1;

use App\Controllers\BaseController;

class MembersViewController extends BaseController
{
    /**
     * return login page.
     *
     * @return void
     */
    public function loginPage()
    {
        return view('loginPage');
    }

    /**
     * return register page.
     *
     * @return void
     */
    public function registerPage()
    {
        return view('registerPage');
    }
}
