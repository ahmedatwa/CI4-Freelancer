<?php namespace Admin\Models\Localisation;

use CodeIgniter\Model;

class Currencies extends Model
{
    protected $table          = 'currency';
    protected $primaryKey     = 'currency_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['title', 'code', 'symbol_left', 'symbol_right', 'value', 'status'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    public function addCurrency($data)
    {
        $builder = $this->db->table('currency');
        $currency_data = [
            'title'        => $data['title'],
            'code'         => $data['code'],
            'symbol_left'  => $data['symbol_left'],
            'symbol_right' => $data['symbol_right'],
            'value'        => $data['value'],
            'status'       => $data['status'],
        ];

        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($currency_data);

        $currency_id = $this->db->insertID();

        if (service('registry')->get('config_currency_auto')) {
            //$this->refresh(true);
        }

        cache()->delete('currency');
        
        return $currency_id;
    }

    public function editCurrency($currency_id, $data)
    {
        $builder = $this->db->table('currency');
        $currency_data = [
            'title'        => $data['title'],
            'code'         => $data['code'],
            'symbol_left'  => $data['symbol_left'],
            'symbol_right' => $data['symbol_right'],
            'value'        => $data['value'],
            'status'       => $data['status'],
        ];

        $builder->where('currency_id', $currency_id);
        $builder->set('date_modified', 'NOW()', false);
        $builder->update($currency_data);

        cache()->delete('currency');
    }

    public function deleteCurrency($currency_id)
    {
        $builder = $this->db->table('currency');
        $builder->delete(['currency_id' => $currency_id]);
        cache()->delete('currency');
    }

    public function getCurrency($currency_id)
    {
        $builder = $this->db->table('currency');
        $builder->distinct();
        $builder->where('currency_id', $currency_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getCurrencyByCode($currency)
    {
        $builder = $this->db->table('currency');
        $builder->distinct();
        $builder->where('code', $currency);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getCurrencies($data = [])
    {
        if ($data) {
            $builder = $this->db->table('currency');
            $builder->select();


            // $sort_data = array(
            //     'title',
            //     'code',
            //     'value',
            //     'date_modified'
            // );

            // if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            //     $sql .= " ORDER BY " . $data['sort'];
            // } else {
            //     $sql .= " ORDER BY title";
            // }

            // if (isset($data['order']) && ($data['order'] == 'DESC')) {
            //     $sql .= " DESC";
            // } else {
            //     $sql .= " ASC";
            // }

            if (isset($data['start']) || isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }
                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }
                $builder->limit($data['limit'], $data['start']);
            }



            $query = $builder->get();
            return $query->getResultArray();
        } else {
            $currency_data = cache()->get('currency');

            if (!$currency_data) {
                $currency_data = [];
                $builder = $this->db->table('currency');
                $builder->select();
                $builder->orderBy('title', 'ASC');
                $query = $builder->get();
                foreach ($query->getResultArray() as $result) {
                    $currency_data[$result['code']] = [
                        'currency_id'   => $result['currency_id'],
                        'title'         => $result['title'],
                        'code'          => $result['code'],
                        'symbol_left'   => $result['symbol_left'],
                        'symbol_right'  => $result['symbol_right'],
                        'value'         => $result['value'],
                        'status'        => $result['status'],
                        'date_modified' => $result['date_modified']
                    ];
                }

                $cache()->save('currency', $currency_data);
            }

            return $currency_data;
        }
    }

    public function refresh($force = false)
    {
        $currency_data = [];

        if ($force) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $this->db->escape($this->config->get('config_currency')) . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $this->db->escape($this->config->get('config_currency')) . "' AND date_modified < '" .  $this->db->escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "'");
        }

        foreach ($query->rows as $result) {
            $currency_data[] = $this->config->get('config_currency') . $result['code'] . '=X';
            $currency_data[] = $result['code'] . $this->config->get('config_currency') . '=X';
        }

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'http://download.finance.yahoo.com/d/quotes.csv?s=' . implode(',', $currency_data) . '&f=sl1&e=.json');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $content = curl_exec($curl);
        
        curl_close($curl);

        $line = explode("\n", trim($content));

        for ($i = 0; $i < count($line); $i = $i + 2) {
            $currency = utf8_substr($line[$i], 4, 3);
            $value = utf8_substr($line[$i], 11, 6);
            
            if ((float)$value < 1 && isset($line[$i + 1])) {
                $value = (1 / utf8_substr($line[$i + 1], 11, 6));
            }
                        
            if ((float)$value) {
                $this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '" . (float)$value . "', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($currency) . "'");
            }
        }

        $this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '1.00000', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($this->config->get('config_currency')) . "'");

        $this->cache->delete('currency');
    }

    public function getTotalCurrencies()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "currency");

        return $query->row['total'];
    }
    // -----------------------------------------------------------------
}
