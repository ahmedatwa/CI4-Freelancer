<?php namespace Admin\Models\Setting;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table          = 'event';
    protected $primaryKey     = 'event_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['code', 'action', 'status', 'priority'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;

    // protected function afterUpdateEvent(array $data)
    // {
    //     \CodeIgniter\Events\Events::trigger('user_activity_update', 'Setting');
    // }

    public function disableEvent($event_id)
    {
        $builder = $this->db->table($this->table);
        $builder->set('status', 0);
        $builder->where('event_id', $event_id);
        $builder->update();
    }

    public function enableEvent($event_id)
    {
        $builder = $this->db->table($this->table);
        $builder->set('status', 1);
        $builder->where('event_id', $event_id);
        $builder->update();
    }

    public function install(string $type, string $code)
    {    
        $builder = $this->db->table($this->table);
       // var_dump($this->getInstalled($type));
        if (!in_array($code, $this->getInstalled($type))) {
            $data = array(
                'type' => $type,
                'code' => $code
            );
            $builder->insert($data, TRUE);
        }
        
    }

    public function uninstall($type, $code)
    {
        $extension = $this->db->table($this->table);
        $extension->delete(['type' => $type, 'code' => $code]);
        $setting = $this->db->table('setting');
        $setting->delete(['code' => $type . '_' . $code]);
    }

    public function addExtensionInstall()
    {
    }

    // ----------------------------------------------------
}
