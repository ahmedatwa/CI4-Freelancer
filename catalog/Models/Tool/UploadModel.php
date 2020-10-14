<?php namespace Catalog\Models\Tool;

class UploadModel extends \CodeIgniter\Model
{
    protected $table          = 'project_to_upload';
    protected $primaryKey     = 'upload_id';
    protected $returnType     = 'array';

    protected $allowedFields = ['project_id', 'freelancer_id', 'filename', 'type', 'size', 'code'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    // --------------------------------------------
}
