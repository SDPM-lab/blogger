<?php

namespace App\Models\V1;

use CodeIgniter\Model;

class TodoListsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'TodoLists';
    protected $primaryKey       = 't_key';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        't_title', 't_content', 'm_key'
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

    /**
     * Find all user todo builder.
     *
     * @param integer $m_key
     * @return \CodeIgniter\Database\BaseBuilder|false
     */
    public function getAllTodoByUserBuilder(int $m_key): \CodeIgniter\Database\BaseBuilder|false
    {
        $builder = $this->db->table("TodoLists")
                            ->where("m_key", $m_key)
                            ->where("deleted_at", null);
        return $builder ?? false;
    }
}
