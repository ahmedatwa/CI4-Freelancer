<?php namespace Catalog\Models\Tool;


class DownloadModel extends \CodeIgniter\Model
{
    protected $table          = 'download';
    protected $primaryKey     = 'download_id';
    protected $returnType     = 'array';
    protected $allowedFields = ['filename'];
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    // -------------------------------------------
}
