<?php namespace Catalog\Models\Localization;

class CurrencyModel extends \CodeIgniter\Model
{

   public function getCurrencyByCode($currency) {
   		$builder = $this->db->table('currency');
   		$builder->distinct();
   		$builder->where('code', $currency);
   		$query = $builder->get();
   		return $query->getRowArray();
	}

	public function getCurrencies() {

		$currency_data = cache()->get('currency');

		if (!$currency_data) {
			$currency_data = [];

			$builder = $this->db->table('currency');
			$builder->select()->orderBy('title', 'ASC');
	   		$query = $builder->get();

			foreach ($query->getResultArray() as $result) {
				$currency_data[$result['code']] = array(
					'currency_id'   => $result['currency_id'],
					'title'         => $result['title'],
					'code'          => $result['code'],
					'symbol_left'   => $result['symbol_left'],
					'symbol_right'  => $result['symbol_right'],
					'decimal_place' => $result['decimal_place'],
					'value'         => $result['value'],
					'status'        => $result['status'],
					'date_modified' => $result['date_modified']
				);
			}

			cache()->save('currency', $currency_data);
		}

		return $currency_data;
	}

    // -------------------------------------------------
}
