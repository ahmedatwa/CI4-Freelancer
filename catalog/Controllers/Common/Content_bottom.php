<?php namespace Catalog\Controllers\Common;

class Content_bottom extends \Catalog\Controllers\BaseController
{
    public function index()
    {

        if ($this->request->uri->getPath()) {
            $route = $this->request->uri->getPath();
        } 

        if (!$route || $route == '/') {
             $route = 'common/home';
        }
            
        $moduleModel = new \Catalog\Models\Setting\Modules();

        $layoutModel = new \Catalog\Models\Design\Layouts();

        $data['modules'] = [];

        $layout_id = $layoutModel->getLayout($route);

        if (!$layout_id) {
            $layout_id = $this->registry->get('config_layout_id');
        }

        $modules = $layoutModel->getLayoutModules($layout_id, 'content_bottom');

        foreach ($modules as $module) {

            $part = explode('.', $module['code']);

            $basename = ucfirst($part[0]);

            if (isset($basename) ) {

                $module_data = view_cell("Catalog\Controllers\Module\\{$basename}::index");

                if ($module_data) {
                    $data['modules'][] = $module_data;
                }
            }

            if (isset($part[1])) {

                $setting_info = $moduleModel->getModule($part[1]);

                if ($setting_info && $setting_info['status']) {
                   $output = view_cell("Catalog\Controllers\Module\\{$basename}::index", $setting_info);

                    if ($output) {
                        $data['modules'][] = $output;
                    }
                }
            }
        }


        return view('common/content_bottom', $data);
    }


    //--------------------------------------------------------------------
}