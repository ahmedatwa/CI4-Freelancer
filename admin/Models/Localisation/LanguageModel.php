<?php namespace Admin\Models\Localisation;

use CodeIgniter\Model;

class LanguageModel extends Model
{
    protected $table          = 'language';
    protected $primaryKey     = 'language_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['name', 'code', 'locale', 'image', 'directory', 'sort_order', 'status'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';
    protected $deletedField = 'date_deleted';

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        }
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        }
    }

    public function addLanguage($data)
    {
        $builder = $this->db->table($this->table);
        $language_data = array(
            'name' => $data['name'],
            'code' => $data['code'],
            'locale' => $data['locale'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        );
        $builder->insert($language_data);

        $language_id = $this->db->insertID();

        /**
         * Updating all Tables with new Lanuage Added
        */

        // Information
        $information = $this->db->table('information_description');
        $information->select()
        ->where('language_id', getSettingItem('config_language_id'));
        $query = $information->get();
        foreach ($query->getResultArray() as $result) {
            $information_data = array(
                'information_id'   => $result['information_id'],
                'language_id'      => $language_id,
                'title'            => $result['title'],
                'description'      => $result['description'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
            );
            $information->insert($information_data);
        }
    }


    public function editLanguage($language_id, $data)
    {
        $builder = $this->db->table($this->table);
        $language_data = array(
            'name' => $data['name'],
            'code' => $data['code'],
            'locale' => $data['locale'],
            'sort_order' => $data['sort_order'],
            'status' => $data['status']
        );
        $builder->where('language_id', $language_id);
        $builder->update($language_data);
    }

    // -----------------------------------------------------------------
}
