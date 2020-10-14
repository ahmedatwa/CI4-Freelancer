<?php namespace Catalog\Models\Localization;

class ProjectStatusModel extends \CodeIgniter\Model
{

   public function getProjectStatus($status_id) {
   		$builder = $this->db->table('project_status');
   		$builder->select();
   		$builder->where(['status_id' => $status_id, 'language_id' => service('registry')->get('config_language_id')]);
		$query = $builder->get();
		return $query->getRowArray();
	}

	public function getProjectSatuses()
	{
		$builder = $this->db->table('project_status');
		$builder->select();
   		$builder->where('language_id', service('registry')->get('config_language_id'));
   		$query = $builder->get();
   		return $query->getResultArray();
	}

    // -------------------------------------------------
}
