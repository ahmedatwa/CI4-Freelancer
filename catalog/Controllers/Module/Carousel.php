<?php namespace Catalog\Controllers\Module;

use \Catalog\Models\Design\Banners;

class Carousel extends \Catalog\Controllers\BaseController
{
    public function index($setting)
    {
        $bannerModel = new Banners();
        
        $data['banners'] = [];

        $results = $bannerModel->getBanner($setting['banner_id']);

        foreach ($results as $result) {
            if (is_file(DIR_IMAGE . $result['image'])) {
                $data['banners'][] = [
                'title' => $result['title'],
                'link'  => $result['link'],
                'image' => $this->resize($result['image'], $setting['width'], $setting['height'])
            ];
            }
        }

        $data['autoplay'] = $setting['autoplay'] ? 'true' : 'false';
        $data['dots']     = $setting['dots'] ? 'true' : 'false';
        $data['infinite'] = $setting['infinite'] ? 'true' : 'false';
        $data['arrows']   = $setting['arrows'] ? 'true' : 'false';

        return view('module/carousel', $data);
    }

    // ------------------------------------------------
}
