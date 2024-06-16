<?php

namespace App\Models\V1;

use CodeIgniter\Model;
use App\Entities\MembersEntity;

class MembersModel extends Model
{
    protected $DBGroup          = USE_DB_GROUP;
    protected $table            = 'Members';
    protected $primaryKey       = 'm_key';
    protected $useAutoIncrement = true;
    protected $returnType       = MembersEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'm_account', 'm_password', 'm_name'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
