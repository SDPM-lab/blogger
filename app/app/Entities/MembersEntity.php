<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MembersEntity extends Entity
{
    /**
     * 主鍵
     *
     * @var int
     */
    protected $m_key;

    /**
     * 帳號
     *
     * @var string
     */
    protected $m_account;

    /**
     * 密碼
     *
     * @var string
     */
    protected $m_password;

    /**
     * 名稱
     *
     * @var string
     */
    protected $m_name;

    /**
     * 新增時間
     *
     * @var datetime
     */
    protected $created_at;

    /**
     * 更新時間
     *
     * @var datetime
     */
    protected $updated_at;

    /**
     * 刪除時間
     *
     * @var datetime
     */
    protected $deleted_at;
}

