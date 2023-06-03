<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use App\Models\V1\TodoListsModel;
use CodeIgniter\API\ResponseTrait;
use monken\TablesIgniter;

class TodoController extends BaseController
{
    use ResponseTrait;

    /**
     * TodoListsModel
     *
     * @var TodoListsModel
     */
    protected TodoListsModel $todoListsModel;

    public function __construct()
    {
        $this->todoListsModel = new TodoListsModel();
    }

    public function index()
    {
        // Get user data in session.
        $user = $this->session->get('user');

        // Get all todo lists.
        $todoLists = $this->todoListsModel->where('m_key', $user["key"])->findAll();

        return $this->respond([
            "msg" => "success",
            "data" => $todoLists
        ]);
    }
}
