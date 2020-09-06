<?php namespace Catalog\Controllers\Common;

use CodeIgniter\Controller;

class Content_top extends Controller
{
    public function index()
    {
        $template = single_service('template');
        $customer = single_service('customer');

        $this->load->model('setting/module');

        $data['modules'] = array();

        $modules = $this->model_design_layout->getLayoutModules($layout_id, 'content_top');

        foreach ($modules as $module) {
            $part = explode('.', $module['code']);

            if (isset($part[0]) && $this->config->get('module_' . $part[0] . '_status')) {
                $module_data = $this->load->controller('extension/module/' . $part[0]);

                if ($module_data) {
                    $data['modules'][] = $module_data;
                }
            }

            if (isset($part[1])) {
                $setting_info = $this->model_setting_module->getModule($part[1]);

                if ($setting_info && $setting_info['status']) {
                    $output = $this->load->controller('extension/module/' . $part[0], $setting_info);

                    if ($output) {
                        $data['modules'][] = $output;
                    }
                }
            }
        }


        return view ('common/menu', $data);
    }


    //--------------------------------------------------------------------
}