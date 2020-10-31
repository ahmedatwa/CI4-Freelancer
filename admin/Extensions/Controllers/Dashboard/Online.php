<?php namespace Extensions\Controllers\Dashboard;

class Online extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('dashboard/online.list.heading_title'));

        $settings = new \Admin\Models\Setting\Settings();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $settings->editSetting('dashboard_online', $this->request->getPost());

            return redirect()->to(base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard'))
                             ->with('success', lang('dashboard/online.text_success'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }
    
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('dashboard/online.list.text_extension'),
            'href' => base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard')
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('dashboard/online.list.heading_title'),
            'href' => base_url('index.php/extension/dashboard/online?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['action'] = base_url('index.php/extensions/dashboard/online?user_token=' . $this->request->getVar('user_token'));

        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard');

        if ($this->request->getPost('dashboard_online_width')) {
            $data['dashboard_online_width'] = $this->request->getPost('dashboard_online_width');
        } else {
            $data['dashboard_online_width'] = $this->registry->get('dashboard_online_width');
        }
    
        $data['columns'] = [];
        
        for ($i = 3; $i <= 12; $i++) {
            $data['columns'][] = $i;
        }
                
        if ($this->request->getPost('dashboard_online_status')) {
            $data['dashboard_online_status'] = $this->request->getPost('dashboard_online_status');
        } else {
            $data['dashboard_online_status'] = $this->registry->get('dashboard_online_status');
        }

        if ($this->request->getPost('dashboard_online_sort_order')) {
            $data['dashboard_online_sort_order'] = $this->request->getPost('dashboard_online_sort_order');
        } else {
            $data['dashboard_online_sort_order'] = $this->registry->get('dashboard_online_sort_order');
        }

        $this->document->moduleOutput('Extensions', 'dashboard\online_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'dashboard/online')) {
            $this->session->setFlashdata('error_warning', lang('dashboard/online.error_permission'));
        }
        return true;
    }
    
    public function dashboard()
    {
        $data['heading_title'] = lang('dashboard/online.list.heading_title');
        $data['text_view'] = lang('dashboard/online.list.text_view');

        $data['user_token'] = $this->request->getVar('user_token');

        // Total Orders
        $onlineModel = new \Extensions\Models\Dashboard\Onlines();

        // Customers Online
        $online_total = $onlineModel->getTotalOnline();

        if ($online_total > 1000000000000) {
            $data['total'] = round($online_total / 1000000000000, 1) . 'T';
        } elseif ($online_total > 1000000000) {
            $data['total'] = round($online_total / 1000000000, 1) . 'B';
        } elseif ($online_total > 1000000) {
            $data['total'] = round($online_total / 1000000, 1) . 'M';
        } elseif ($online_total > 1000) {
            $data['total'] = round($online_total / 1000, 1) . 'K';
        } else {
            $data['total'] = $online_total;
        }

        $data['online'] = base_url('index.php/report/online?user_token=' . $this->request->getVar('user_token'));

        return view('Extensions\Views\template\dashboard\online_info', $data);
    }
}
