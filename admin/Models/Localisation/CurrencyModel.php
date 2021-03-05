<?php 

namespace Admin\Models\Localisation;

use CodeIgniter\Model;

class CurrencyModel extends Model
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
            $this->refresh(service('registry')->get('config_currency'));
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

            if (! $currency_data) {
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

                cache()->save('currency', $currency_data);
            }

            return $currency_data;
        }
    }

    public function refresh(string $default = 'EGP')
    {
        $currency_data = [];

        $client = \Config\Services::curlrequest();

        $request = $client->request('POST', 'http://data.fixer.io/api/latest?access_key=95dd47e556d581360e59d3d16575f5c7');

        $response = $request->getBody();

        $response_info = json_decode($response, true);

        if (is_array($response_info) && isset($response_info['rates'])) {
            $currencies = [];

            $currencies['EUR'] = 1.0000;

            foreach ($response_info['rates'] as $key => $value) {
                $currencies[$key] = $value;
            }

            if ($currencies) {
                foreach ($this->getCurrencies() as $result) {
                    if (isset($currencies[$result['code']])) {
                        $from = $currencies['EUR'];

                        $to = $currencies[$result['code']];

                        $this->editValueByCode($result['code'], 1 / ($currencies[$default] * ($from / $to)));
                    }

                    $this->editValueByCode($default, 1);

                    cache()->delete('currency');
                }
            }
        }
    }

    public function editValueByCode(string $code, $value)
    {
        $builder = $this->db->table('currency');
        $builder->set('value', $value);
        $builder->set('date_modified', 'NOW()', false);
        $builder->where('code', $code);
        $builder->update();
        cache()->delete('currency');
    }

    public function getTotalCurrencies()
    {
        $builder = $this->db->table('currency');
        $builder->select();
        return $builder->countAll();
    }

    // -----------------------------------------------------------------
}
