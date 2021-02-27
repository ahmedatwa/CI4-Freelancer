<?php 

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use \Catalog\Models\Design\LayoutModel;
use \Catalog\Models\Setting\ModulesModel;

class Content_bottom extends BaseController
{
    public function index()
    {

        if ($this->request->uri->getPath()) {
            $route = $this->request->uri->getPath();
        } 

        if (! $route || $route == '/') {
             $route = 'common/home';
        }
            
        $moduleModel = new ModulesModel();
        $layoutModel = new LayoutModel();

        $data['modules'] = [];

        $layout_id = $layoutModel->getLayout($route);

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