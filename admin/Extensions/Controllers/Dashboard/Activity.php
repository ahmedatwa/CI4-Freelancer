<?php namespace Extensions\Controllers\Dashboard;

class Activity extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('dashboard/activity.list.heading_title'));
  
        $settingModel = new \Admin\Models\Setting\Settings();
  
        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $settingModel->editSetting('dashboard_activity', $this->request->getPost());
    
            return redirect()->to(base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard'))
                             ->with('success', lang('dashboard/activity.text_success'));
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
        'text' => lang('dashboard/activity.list.text_extension'),
        'href' => base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard')
      ];
  
        $data['breadcrumbs'][] = [
        'text' => lang('dashboard/activity.list.heading_title'),
        'href' => base_url('index.php/extension/dashboard/activity/user_token=' . $this->request->getVar('user_token'))
      ];
  
        $data['action'] = base_url('index.php/extensions/dashboard/activity?user_token=' . $this->request->getVar('user_token'));
  
        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=dashboard');
  
        if ($this->request->getPost('dashboard_activity_width')) {
            $data['dashboard_activity_width'] = $this->request->getPost('dashboard_activity_width');
        } else {
            $data['dashboard_activity_width'] = $this->registry->get('dashboard_activity_width');
        }
      
        $data['columns'] = [];
      
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
  

        $this->document->moduleOutput('Extensions', 'dashboard\activity_form', $data);
    }
  
    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'dashboard/activity')) {
            $this->session->setFlashdata('error_warning', lang('dashboard/activity.error_permission'));
            return false;
        }
        return true;
    }
    
    public function dashboard()
    {
        $data['heading_title'] = lang('dashboard/activity.list.heading_title');
        $data['text_no_results'] = lang('en.text_no_results');

        $data['user_token'] = $this->request->getVar('user_token');
  
        $data['activities'] = [];
  
        $activityModel = new \Extensions\Models\Dashboard\Activities();
  
        $results = $activityModel->where('customer_id !=', 0)->findAll(5);

        foreach ($results as $result) {
            $text = vsprintf(lang('dashboard/activity.list.text_activity_' . $result['key']), json_decode($result['data'], true));
  
            $find = [
              'customer_id=',
              'order_id=',
         ];
  
            $replace = [
              base_url('index.php/customer/customer/edit?user_token=' . $this->request->getVar('user_token') . '&customer_id='),
        ];
  
            $data['activities'][] = [
              'comment'    => str_replace($find, $replace, $text),
              'date_added' => date(lang('en.datetime_format'), strtotime($result['date_added']))
        ];
        }
  
        return view('Extensions\Views\template\dashboard\activity_info', $data);
    }

    // -------------------------------------------------
}
