<?php namespace Admin\Controllers\Report;

use \Admin\Models\Setting\ExtensionModel;

class Report extends \Admin\Controllers\BaseController
{

    public function index()
    {
        
        $this->document->setTitle(lang('report/report.list.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('common/dashboard?user_token=' . $this->session->get('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('report/report.list.heading_title'),
            'href' => base_url('report/report?user_token=' . $this->session->get('user_token'))
        ];

        $data['user_token'] = $this->session->get('user_token');

        if ($this->request->getVar('code')) {
            $data['code'] = $this->request->getVar('code');
        } else {
            $data['code'] = '';
        }

        // Reports
        $data['reports'] = [];
        
        $extensionModel = new ExtensionModel();

        $extensions = $extensionModel->getInstalled('report');

        foreach ($extensions as $code) {
            if ($this->registry->get('report_' . $code . '_status') && $this->user->hasPermission('access', 'extensions/report/' . $code)) {
                
                $data['reports'][] = [
                    'text'       => lang('report/'. $code .'.list.report_heading_title'),
                    'code'       => $code,
                    'sort_order' => $this->registry->get('report_' . $code . '_sort_order'),
                    'href'       => base_url('report/report?user_token=' . $this->session->get('user_token') . '&code=' . $code)
                ];
            }
        }
        
        $sort_order = [];

        foreach ($data['reports'] as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $data['reports']);   
        
        if ($this->request->getVar('code')) {
            $data['report_list'] = view_cell('Extensions\Controllers\Report\\' . ucfirst($this->request->getVar('code')) . '::report');
        } elseif (isset($data['reports'][0])) {
            $data['report_list'] = view_cell('Extensions\Controllers\Report\\' . ucfirst($data['reports'][0]['code']) . '::report');
        } else {
            $data['report_list'] = '';
        }

        $this->document->output('report/report', $data);
    }


    //--------------------------------------------------------------------
}
