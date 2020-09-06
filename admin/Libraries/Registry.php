<?php namespace Admin\Libraries;

class Registry
{
    protected static $data = [];

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
            self::$data[$row->name] = $row->setting;
        }
        log_message('info', 'Registry class initialized');
    }

    public static function get($key)
    {
        if (is_array($key)) {
            $result = array();

            foreach ($key as $k) {
                $result[$k] = self::get($k);
            }

            return $result;
        }

        $key = (string) $key;

        if ($key != '' && array_key_exists($key, self::$data)) {
            return self::$data[$key];
        }

        return null;
    }

    public static function getAll()
    {
        return self::$data;
    }

    public static function set($key, string $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                self::set($k, $v);
            }
            self::$data[$k] = $v;
        } else {
            self::$data[$key] = $value;
        }
    }

    public static function has($key)
    {
        $key = (string) $key;

        return $key != '' && array_key_exists($key, self::$data);
    }

    public static function remove($key)
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                self::remove($k);
            }
        }

        if ($key != '' && array_key_exists($key, self::$data)) {
            unset(self::$data[$key]);
        }
    }

    // --------------------------------------------------------
}
