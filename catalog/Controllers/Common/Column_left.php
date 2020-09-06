<?php namespace Catalog\Controllers\Common;

class Column_left extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if ($this->request->uri->getPath()) {
            $route = $this->request->uri->getPath();
        } else {
            $route = 'common/home';
        }

        $layout_model = new \Catalog\Models\Design\Layouts();

        $module_model = new \Catalog\Models\Setting\Modules();

        $layout_id = $layout_model->getLayout($route);

        if (!$layout_id) {
            $layout_id = getSettingValue('config_layout_id');
        }

        $data['modules'] = [];

        $modules = $layout_model->getLayoutModules($layout_id, 'column_left');

        foreach ($modules as $module) {
            $part = explode('.', $module['code']);

            $basename = ucfirst($part[0]);

            if (isset($part[0]) && getSettingValue('module_' . $part[0] . '_status')) {
                $module_data = view_cell("Catalog\Controllers\Module\\{$basename}::index");

                if ($module_data) {
                    $data['modules'][] = $module_data;
                }
            }

            if (isset($part[1])) {
                $setting_info = $module_model->getModule($part[1]);
                if ($setting_info && $setting_info['status']) {
                    $output = view_cell("Catalog\Controllers\Module\\{$basename}::index", $setting_info);

                    if ($output) {
                        $data['modules'][] = $output;
                    }
                }
            }
        }


        return view('common/column_left', $data);
    }


    //--------------------------------------------------------------------
}
