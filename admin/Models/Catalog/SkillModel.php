<?php 

namespace Admin\Models\Catalog;

use CodeIgniter\Model;

class SkillModel extends Model
{
    protected $table          = 'skills';
    protected $primaryKey     = 'skill_id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'status'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';
    // -----------------------------------------------------------------
}
