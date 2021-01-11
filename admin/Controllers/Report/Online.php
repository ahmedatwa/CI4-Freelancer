<?php namespace Admin\Controllers\Report;

use \Admin\Models\Setting\ExtensionModel;

class Online extends \Admin\Controllers\BaseController
{

    public function index()
    {
        
        $this->document->setTitle(lang('report/online.list.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('common/dashboard?user_token=' . $this->session->get('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('report/online.list.heading_title'),
            'href' => base_url('report/online?user_token=' . $this->session->get('user_token'))
        ];

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $data['user_token'] = $this->session->get('user_token');
        $data['delete'] = '';
        // Reports
        $data['reports'] = [];
        
        $extensionModel = new ExtensionModel();

        $extensions = $extensionModel->getInstalled('report');

        foreach ($extensions as $code) {
            if ($this->registry->get('report_' . $code . '_status') && $this->user->hasPermission('access', 'extensions/report/' . $code)) {
                
                $data['reports'][] = [
                    'text'       => lang('report/'. $code .'.list.heading_title'),
                    'code'       => $code,
                    'sort_order' => $this->registry->get('report_' . $code . '_sort_order'),
                    'href'       => base_url('report/report?user_token=' . $this->session->get('user_token') . '&code=' . $code),
                ];
            }
        }
        
        $this->document->output('report/online', $data);
    }


    //--------------------------------------------------------------------
}
