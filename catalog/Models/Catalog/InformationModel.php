<?php 

namespace Catalog\Models\Catalog;

use CodeIgniter\Model;

class InformationModel extends Model
{
    protected $table         = 'information';
    protected $primaryKey    = 'information_id';
    protected $returnType    = 'array';
    // User Activity Events
    protected $afterInsert   = ['afterInsertEvent'];
    protected $afterUpdate   = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';


	public function getInformations(int $limit = null, int $start = 0)
    {
		$builder = $this->db->table('information');
        $builder->select();
        $builder->join('information_description', 'information_description.information_id = information.information_id', 'left');
        $builder->where('information_description.language_id', service('registry')->get('config_language_id'));
        
        if ($limit) {
            $builder->limit($limit, $start);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getInformation(int $information_id)
    {
		$builder = $this->db->table('information');

        $builder->select();
        $builder->join('information_description', 'information.information_id = information_description.information_id', 'left');
        $builder->where('information.information_id', $information_id);
        $builder->where('information_description.language_id', service('registry')->get('config_language_id'));
        $query = $builder->get();
        return $query->getRowArray();
    }
    
    public function getInformationDescription($information_id)
    {
		$builder = $this->db->table('information_description');

		$information_description_data = [];
		
        $builder->select();
        $builder->where('information_id', $information_id);
        $query = $this->db->get();
        foreach ($query->getResultArray() as $result) {
            $information_description_data[$result['language_id']] = [
                'title'            => $result['title'],
                'description'      => $result['description'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
            ];
        }
        return $information_description_data;
	}
	
    // -----------------------------------------------------------------
}
