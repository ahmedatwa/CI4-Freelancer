<?php 

namespace Catalog\Models\Tool;

use CodeIgniter\Model;

class DownloadModel extends Model
{
	protected $table         = 'download';
	protected $primaryKey    = 'download_id';
	protected $returnType    = 'array';
	protected $allowedFields = ['filename'];
	// should use for keep data record create timestamp
	protected $useTimestamps = true;
	protected $dateFormat    = 'int';
	protected $createdField  = 'date_added';
	protected $updatedField  = 'date_modified';
    // -------------------------------------------
}
