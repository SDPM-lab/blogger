<?php

namespace App\Controllers\RenderView\V1;

use App\Controllers\BaseController;
use monken\TablesIgniter;
use App\Models\V1\TodoListsModel;

class TodoListViewController extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function todoListPage()
    {
        return view('messageBoard/messageBoardOrm');
    }

    public function getDatatableData()
    {
        $table = new TablesIgniter();

        $todoListsModel = new TodoListsModel();

        $user = $this->session->get("user");

        $dataTableField = [
            "t_key", "t_title", "t_content"
        ];

        $table->setTable($todoListsModel->getAllTodoByUserBuilder($user["key"]))
            ->setDefaultOrder("t_key", "DESC")
            ->setSearch($dataTableField)
            ->setOrder($dataTableField)
            ->setOutput([
                "t_key", "t_title", "t_content", $this->getDataTableActionButton()
            ]);

        return $table->getDatatable();
    }

    public function getDataTableActionButton()
    {
        $closureFunction = function ($row) {
            $key = $row["t_key"];
            return <<<EOF
                <button class="btn btn-outline-info" onclick="getModifyMessage('{$key}')"  data-toggle="modal" data-target="#modifyModal">Modify</button>
                <button class="btn btn-outline-danger" onclick="deleteMessage('{$key}')">Delete</button>
            EOF;
        };
        return $closureFunction;
    }
}
