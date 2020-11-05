<?php namespace Admin\Models\Design;

class Banners extends \CodeIgniter\Model
{
    public function addBanner($data)
    {
        $builder = $this->db->table('banner');
        $banner_data = [
            'name'   => $data['name'],
            'status' => $data['status']
        ];

        $builder->insert($banner_data);

        $banner_id = $this->db->insertID();

        if (isset($data['banner_image'])) {
            $banner_image_table = $this->db->table('banner_image');

            foreach ($data['banner_image'] as $language_id => $value) {
                foreach ($value as $banner_image) {
                    $banner_image_data = [
                        'banner_id'   => $banner_id,
                        'language_id' => $language_id,
                        'title'       => $banner_image['title'],
                        'link'        => $banner_image['link'],
                        'image'       => $banner_image['image'],
                        'sort_order'  => $banner_image['sort_order'],
                    ];
                    $banner_image_table->insert($banner_image_data);
                }
            }
        }

        return $banner_id;
    }

    public function editBanner($banner_id, $data)
    {
        $builder = $this->db->table('banner');
        $banner_data = [
            'name'   => $data['name'],
            'status' => $data['status']
        ];

        $builder->where('banner_id', $banner_id);
        $builder->update($banner_data);
        
        if (isset($data['banner_image'])) {
            $banner_image_table = $this->db->table('banner_image');
            $banner_image_table->delete(['banner_id' => $banner_id]);

            foreach ($data['banner_image'] as $language_id => $value) {
                foreach ($value as $banner_image) {
                    $banner_image_data = [
                        'banner_id'   => $banner_id,
                        'language_id' => $language_id,
                        'title'       => $banner_image['title'],
                        'link'        => $banner_image['link'],
                        'image'       => $banner_image['image'],
                        'sort_order'  => $banner_image['sort_order'],
                    ];
                    $banner_image_table->insert($banner_image_data);
                }
            }
        }
    }

    public function getBanners(array $data = [])
    {
        $builder = $this->db->table('banner');

		$sort_data = [
			'name',
			'status'
		];

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$builder->orderBy($data['sort']);
		} else {
		    $builder->orderBy('name');
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$builder->orderBy('name', 'DESC');
		} 

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$builder->limit($data['start'], $data['limit']);
		}

		$query = $builder->get();
		return $query->getResultArray();

    }
    public function deleteBanner($banner_id)
    {
        $builder = $this->db->table('banner');
        $builder->delete(['banner_id' => $banner_id]);
        // Banner Image
        $banner_image_table = $this->db->table('banner_image');
        $banner_image_table->delete(['banner_id' => $banner_id]);
    }

    public function getBanner($banner_id)
    {
        $builder = $this->db->table('banner');
        $builder->distinct();
        $builder->where('banner_id', $banner_id);
        $query = $builder->get();
        return $query->getRowarray();
    }

    public function getBannerImages($banner_id)
    {
        $banner_image_data = [];

        $builder = $this->db->table('banner_image');
        $builder->select();
        $builder->where('banner_id', $banner_id);
        $builder->orderBy('sort_order', 'ASC');
        $query = $builder->get();
        foreach ($query->getResultArray() as $banner_image) {
            $banner_image_data[$banner_image['language_id']][] = [
				'banner_image_id' => $banner_image['banner_image_id'],
				'title'           => $banner_image['title'],
				'link'            => $banner_image['link'],
				'image'           => $banner_image['image'],
				'sort_order'      => $banner_image['sort_order']
            ];
        }

        return $banner_image_data;
    }

    // -----------------------------------------------------------
}
