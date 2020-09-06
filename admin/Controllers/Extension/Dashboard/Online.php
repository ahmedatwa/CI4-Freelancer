<?php namespace Admin\Controllers\Extension\Dashboard;

class Online extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/dashboard/online.list.heading_title'));

        $settings = new \Admin\Models\Setting\Settings();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $settings->editSetting('dashboard_online', $this->request->getPost());

            return redirect()->to(base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=dashboard'))
            ->with('success', lang('extension/dashboard/online.text_success'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }
    
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token'))
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('extension/dashboard/online.list.text_extension'),
            'href' => base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=dashboard')
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('extension/dashboard/online.list.heading_title'),
            'href' => base_url('index.php/extension/dashboard/online?user_token=' . $this->session->get('user_token')),
        );

        $data['action'] = base_url('index.php/extension/dashboard/online?user_token=' . $this->session->get('user_token'));

        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=dashboard');

        if ($this->request->getPost('dashboard_online_width')) {
            $data['dashboard_online_width'] = $this->request->getPost('dashboard_online_width');
        } else {
            $data['dashboard_online_width'] = $this->registry->get('dashboard_online_width');
        }
    
        $data['columns'] = array();
        
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

        $this->document->output('extension/dashboard/online_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/dashboard/online')) {
            $this->session->setFlashdata('error_warning', lang('extension/dashboard/online.error_permission'));
        }
        return true;
    }
    
    public function dashboard()
    {
        $data['heading_title'] = lang('extension/dashboard/online.list.heading_title');
        $data['text_view'] = lang('extension/dashboard/online.list.text_view');

        $data['user_token'] = $this->session->get('user_token');

        // Total Orders
        $onlines = new \Admin\Models\Extension\Dashboard\Onlines();

        // Customers Online
        $online_total = $onlines->getTotalOnline();

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

        $data['online'] = base_url('index.php/report/online?user_token=' . $this->session->get('user_token'));

        return view('extension/dashboard/online_info', $data);
    }
}
