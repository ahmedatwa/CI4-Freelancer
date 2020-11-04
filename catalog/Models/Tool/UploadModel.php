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


    // for project attachments
    public function addAttachment($data)
    {
    	$builder = $this->db->table('download');
    	$upload_data = [
			'filename'  => $data['filename'],
			'code'      => $data['code'],
			'ext'       => $data['ext'],
    	];

    	$builder->set('date_added', 'NOW()', false);
    	$builder->set('date_modified', 'NOW()', false);
    	$builder->insert($upload_data);

    	return $this->db->insertID();
    } 

    // --------------------------------------------
}
