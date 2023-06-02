<?php

namespace App\Controllers\RenderView\V1;

use App\Controllers\BaseController;

class MembersViewController extends BaseController
{
    public function loginPage()
    {
        return view('loginPage');
    }
}
