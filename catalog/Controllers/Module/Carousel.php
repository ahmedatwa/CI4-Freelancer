<?php namespace Catalog\Controllers\Module;

class Carousel extends \Catalog\Controllers\BaseController
{
    public function index($setting)
    {
        static $module = 0;

        $banner_model = new \Catalog\Models\design\Banners();
        
        $this->template->addStyle('assets/vendor/javascript/jquery/swiper/css/swiper.min.css');
        $this->template->addStyle('assets/vendor/javascript/jquery/swiper/css/opencart.css');
        $this->template->addScript('assets/vendor/javascript/jquery/swiper/js/swiper.jquery.js');

        $data['banners'] = [];

        $result = $banner_model->getBanner($setting['banner_id']);


        if (is_file(DIR_IMAGE . $result['image'])) {
            $data['banners'][] = [
                'title' => $result['title'],
                'link'  => $result['link'],
                'image' => $result['image']
            ];
        }

        $data['module'] = $module++;


        return view('extension/module/carousel', $data);
    }
}
