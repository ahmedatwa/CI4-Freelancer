<?php namespace Admin\Controllers\Extension\Dashboard;

class Activity extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/dashboard/activity.list.heading_title'));
  
        $setting_model = new \Admin\Models\Setting\Settings();
  
        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $setting_model->editSetting('dashboard_activity', $this->request->getPost());
    
            return redirect()->to(base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=dashboard'))
                         ->with('success', lang('extension/dashboard/activity.text_success'));
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
        'text' => lang('extension/dashboard/activity.list.text_extension'),
        'href' => base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=dashboard')
      );
  
        $data['breadcrumbs'][] = array(
        'text' => lang('extension/dashboard/activity.list.heading_title'),
        'href' => base_url('index.php/extension/dashboard/activity/user_token=' . $this->session->get('user_token'))
      );
  
        $data['action'] = base_url('index.php/extension/dashboard/activity?user_token=' . $this->session->get('user_token'));
  
        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=dashboard');
  
        if ($this->request->getPost('dashboard_activity_width')) {
            $data['dashboard_activity_width'] = $this->request->getPost('dashboard_activity_width');
        } else {
            $data['dashboard_activity_width'] = $this->registry->get('dashboard_activity_width');
        }
      
        $data['columns'] = array();
      
        for ($i = 3; $i <= 12; $i++) {
            $data['columns'][] = $i;
        }
      
        if ($this->request->getPost('dashboard_activity_status')) {
            $data['dashboard_activity_status'] = $this->request->getPost('dashboard_activity_status');
        } else {
            $data['dashboard_activity_status'] = $this->registry->get('dashboard_activity_status');
        }
  
        if ($this->request->getPost('dashboard_activity_sort_order')) {
            $data['dashboard_activity_sort_order'] = $this->request->getPost('dashboard_activity_sort_order');
        } else {
            $data['dashboard_activity_sort_order'] = $this->registry->get('dashboard_activity_sort_order');
        }
  
        $this->document->output('extension/dashboard/activity_form', $data);
    }
  
    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/dashboard/activity')) {
            $this->session->setFlashdata('error_warning', lang('extension/dashboard/activity.error_permission'));
            return false;
        }
        return true;
    }
    
    public function dashboard()
    {
        $data['heading_title'] = lang('extension/dashboard/activity.list.heading_title');
        $data['text_no_results'] = lang('en.text_no_results');

        $data['user_token'] = $this->session->get('user_token');
  
        $data['activities'] = array();
  
        $extensionModel = new \Admin\Models\Extension\Dashboard\Activities();
  
        $results = $extensionModel->findAll(5);

        foreach ($results as $result) {
            $text = vsprintf(lang('extension/dashboard/activity.list.text_activity_' . $result['key']), json_decode($result['data'], true));
  
            $find = array(
          'customer_id=',
          'order_id=',
        );
  
            $replace = array(
          base_url('index.php/customer/customer/edit?user_token=' . $this->session->get('user_token') . '&customer_id='),
          base_url('index.php/sale/order/info?user_token=' . $this->session->get('user_token') . '&order_id='),
        );
  
            $data['activities'][] = array(
          'comment'    => str_replace($find, $replace, $text),
          'date_added' => date(lang('en.datetime_format'), strtotime($result['date_added']))
        );
        }
  
        return view('extension/dashboard/activity_info', $data);
    }

    // -------------------------------------------------
}
