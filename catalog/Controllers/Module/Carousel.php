<?php 

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;
use Catalog\Models\Design\BannerModel;

class Carousel extends BaseController
{
    public function index($setting)
    {
        $bannerModel = new BannerModel();
        
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