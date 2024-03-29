<?php namespace Extensions\Controllers\Report;

use \Extensions\Models\Report\ActivityModel;
use \Admin\Models\Setting\SettingModel;

class User_activity extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('report/report.list.heading_title'));

        $settingModel = new SettingModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $settingModel->editSetting('report_user_activity', $this->request->getPost());

            return redirect()->to(base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=report'))
                             ->with('success', lang('extension/report/report.text_success'));
        }

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extensions?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('report/report.list.heading_title'),
            'href' => base_url('index.php/extensions/report/user_activity?user_token=' . $this->session->get('user_token')),
        ];

        $data['action'] = base_url('index.php/extensions/report/user_activity?user_token=' . $this->session->get('user_token'));
        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=report');

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getPost('report_user_activity_status')) {
            $data['report_user_activity_status'] = $this->request->getPost('report_user_activity_status');
        } elseif (!empty($this->registry->get('report_user_activity_status'))) {
            $data['report_user_activity_status'] = $this->registry->get('report_user_activity_status');
        } else {
            $data['report_user_activity_status'] = '';
        }

        if ($this->request->getPost('report_user_activity_sort_order')) {
            $data['report_user_activity_sort_order'] = $this->request->getPost('report_user_activity_sort_order');
        } elseif (!empty($this->registry->get('report_user_activity_sort_order'))) {
            $data['report_user_activity_sort_order'] = $this->registry->get('report_user_activity_sort_order');
        } else {
            $data['report_user_activity_sort_order'] = 1;
        }

        $this->document->moduleOutput('Extensions', 'report\user_activity_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extensions/report/user_activity')) {
            $this->session->setFlashdata('error_warning', lang('report/user_activity.error_permission'));
            return false;
        }
        return true;
    }

    public function report()
    {
        $data['activities'] = [];

        $activityModel = new ActivityModel();

        $total = $activityModel->getTotalActivities();
        $results = $activityModel->getActivities();

        foreach ($results as $result) {
            $comment = vsprintf(lang('report/user_activity.user_' . $result['key']), json_decode($result['data'], true));

            $find = [
                'user_id=',
                'user_group_id=',
                'project_id=',
                'information_id=',
                'review_id=',
                'customer_id=',
                'customer_group_id=',
                'category_id=',
            ];

            $replace = [
                base_url('index.php/user/user/edit?user_token=' . $this->request->getVar('user_token') . '&user_id='),
                base_url('index.php/user/user_group/edit?user_token=' . $this->request->getVar('user_token') . '&user_group_id='),
                base_url('index.php/catalog/project/edit?user_token=' . $this->request->getVar('user_token') . '&project_id='),
                base_url('index.php/catalog/information/edit?user_token=' . $this->request->getVar('user_token') . '&information_id='),
                base_url('index.php/catalog/review/edit?user_token=' . $this->request->getVar('user_token') . '&review_id='),
                base_url('index.php/customer/customer/edit?user_token=' . $this->request->getVar('user_token') . '&customer_id='),
                base_url('index.php/customer/customer_group/edit?user_token=' . $this->request->getVar('user_token') . '&customer_group_id='),
                base_url('index.php/catalog/category/edit?user_token=' . $this->request->getVar('user_token') . '&category_id='),
            ];

            $data['activities'][] = [
                'activity_id' => $result['activity_id'],
                'ip'          => $result['ip'],
                'date_added'  => dateFormatLong($result['date_added']),
                'comment'     => str_replace($find, $replace, $comment),
                'user_agent'  => $result['user_agent'],
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->getFlashdata('error')) {
            $data['error'] = $this->session->getFlashdata('error');
        } else {
            $data['error'] = '';
        }

        $data['column_comment']       = lang('report/user_activity.list.column_comment');
        $data['column_ip']            = lang('report/user_activity.list.column_ip');
        $data['column_date_added']    = lang('report/user_activity.list.column_date_added');
        $data['column_user_agent']    = lang('report/user_activity.list.column_user_agent');
        $data['report_heading_title'] = lang('report/user_activity.list.heading_title');

        $data['delete'] = base_url('index.php/report/activity/delete?user_token=' . $this->request->getVar('user_token'));

        return view ('Extensions\Views\template\report\user_activity_info', $data);
    }

    //--------------------------------------------------------------------
}
