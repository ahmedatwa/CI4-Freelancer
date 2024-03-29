<?php namespace Admin\Controllers\Common;

use \Admin\Models\Setting\ExtensionModel;

class Dashboard extends \Admin\Controllers\BaseController
{
    public function index()
    {
        if (! $this->request->getVar('user_token') || ! $this->session->get('user_token') || ($this->request->getVar('user_token') != $this->session->get('user_token'))) {
            return redirect()->to(base_url('index.php/common/login'))->with('error', lang('en.error.error_token'));
        }

        $this->document->setTitle(lang('common/dashboard.list.heading_dashboard'));

        $data['user_token'] = $this->session->get('user_token');
        
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('common/dashboard?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('common/dashboard.list.heading_dashboard'),
            'href' => base_url('common/dashboard?user_token=' . $this->request->getVar('user_token'))
        ];
        

        // Check install directory exists
        if ((is_dir(ROOTPATH . 'install')) || (is_dir(FCPATH . '../install'))) {
            $data['error_install'] = sprintf(lang('common/dashboard.error_install'), base_url('common/dashboard/removeInstall'));
        } else {
            $data['error_install'] = '';
        }
        
        // Dashboard Extensions
        $dashboards = [];

        $extensionsModel = new ExtensionModel();

        // Get a list of installed modules
        $extensions = $extensionsModel->getInstalled('dashboard');

        // Add all the modules which have multiple settings for each module
        foreach ($extensions as $code) {
            if ($this->registry->get('dashboard_' . $code . '_status') && $this->user->hasPermission('access', 'extensions/dashboard/' . $code)) {
                $controller = ucfirst($code);
                // Loading controller Method
                $output = view_cell("Extensions\Controllers\Dashboard\\{$controller}::dashboard");

                $dashboards[] = [
                    'code'       => $code,
                    'width'      => $this->registry->get('dashboard_' . $code . '_width'),
                    'sort_order' => $this->registry->get('dashboard_' . $code . '_sort_order'),
                    'output'     => $output,
                ];
            }
        }
        
        $data['dashboards'] = [];
        
        $sort_order = [];

        foreach ($dashboards as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $dashboards);
        
        foreach ($dashboards as $dashboard) {
            $data['dashboards'][] = $dashboard;
        }
        
        return $this->document->output('common/dashboard', $data);
    }

    public function removeInstall()
    {
        $json = [];
        if ($this->request->isAJAX() && $this->request->getMethod() == 'post') {
            if ((is_dir(ROOTPATH . 'install')) || (is_dir(FCPATH . '../install'))) {
                helper('filesystem');
                if (is_dir(ROOTPATH . 'install')) {
                    // Remove Main Root Install Dir
                    delete_files(ROOTPATH . 'install', true, false, true);
                    rmdir(ROOTPATH . 'install');
                }
                // remove public install filder
                if (is_dir(FCPATH . '../install')) {
                    delete_files(FCPATH . '../install', true, false, true);
                    rmdir(realpath(FCPATH . '../install'));
                }
                $json['success'] = 'Install Folder Deleted Successfully!';
            } else {
                $json['error'] = 'Install Folder Not Found!';
            }
        }
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
