<?php 

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use Catalog\Models\Design\LayoutModel;
use Catalog\Models\Setting\ModulesModel;

class Column_right extends BaseController
{
    public function index()
    {
        if ($this->request->uri->getSegment(1)) {
            $route = $this->request->uri->getSegment(1);
        } 

        if (! $route || $route == '/') {
             $route = 'common/home';
        }

        $layoutModel = new LayoutModel();
        $moduleModel = new ModulesModel();

        $data['modules'] = [];
        
        $layout_id = $layoutModel->getLayout($route);

        $modules = $layoutModel->getLayoutModules($layout_id, 'column_right');

        foreach ($modules as $module) {

            $part = explode('.', $module['code']);

            $basename = ucfirst($part[0]);

            if (isset($part[0]) && $this->registry->get('module_' . $part[0] . '_status')) {

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

        return view('common/column_right', $data);
    }


    //--------------------------------------------------------------------
}
