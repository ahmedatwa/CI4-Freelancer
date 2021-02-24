<?php 

namespace Catalog\Libraries;

class Registry
{
    protected $data = [];

    public function __construct()
    {
        /***
        // fetch the setting vars when needed instead of loading model in controllers
        @ return string
        */
        $db = db_connect();
        $builder = $db->table('setting');
        $builder->where('site_id', 0);
        $query = $builder->get();
        foreach ($query->getResult() as $row) {
            $this->data[$row->name] = $row->setting;
        }
        log_message('info', 'Registry class initialized');
    }

    public function get($key)
    {
        if (is_array($key)) {
            $result = array();

            foreach ($key as $k) {
                $result[$k] = $this->get($k);
            }

            return $result;
        }

        $key = (string) $key;

        if ($key != '' && array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;
    }

    public function getAll()
    {
        return $this->data;
    }

    public function set($key, string $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
            $this->data[$k] = $v;
        } else {
            $this->data[$key] = $value;
        }
    }

    public function has($key)
    {
        $key = (string) $key;

        return $key != '' && array_key_exists($key, $this->data);
    }

    public function remove($key)
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                $this->remove($k);
            }
        }

        if ($key != '' && array_key_exists($key, $this->data)) {
            unset($this->data[$key]);
        }
    }

    // --------------------------------------------------------
}
