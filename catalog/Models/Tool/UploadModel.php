<?php 

namespace Catalog\Models\Tool;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class UploadModel extends Model
{
    protected $table         = 'project_to_upload';
    protected $primaryKey    = 'upload_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['project_id', 'freelancer_id', 'filename', 'type', 'size', 'code'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';


    // for project attachments
    public function addAttachment($data)
    {
    	$builder = $this->db->table('download');
    	$upload_data = [
            'filename'      => $data['filename'],
            'code'          => $data['code'],
            'ext'           => $data['ext'],
            'date_added'    => Time::now()->getTimestamp(),
            'date_modified' =>Time::now()->getTimestamp(),
    	];

    	$builder->insert($upload_data);
    	return $this->db->insertID();
    } 

    // --------------------------------------------
}
