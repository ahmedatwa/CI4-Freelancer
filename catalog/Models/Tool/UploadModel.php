<?php 

namespace Catalog\Models\Tool;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class UploadModel extends Model
{
    protected $table         = 'upload';
    protected $primaryKey    = 'upload_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['project_id', 'customer_id', 'filename', 'ext', 'type', 'size', 'code'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    // --------------------------------------------
}
