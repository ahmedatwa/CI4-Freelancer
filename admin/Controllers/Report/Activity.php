<?php namespace Admin\Controllers\Report;

use \Admin\Models\Report\ActivityModel;

class Activity extends \Admin\Controllers\BaseController
{

    public function index()
    {
        $activityModel = new ActivityModel();

        $this->document->setTitle(lang('tool/log.list.heading_title'));

        $this->getList();

    }

    public function getList()
    {

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

        $data['activities'] = [];

        $activityModel = new ActivityModel();

        $total = $activityModel->getTotalActivities();
        $results = $activityModel->getActivities();

        foreach ($results as $result) {
            $find = [
                'user_id=',
                'product_id=',
                'new_user_id=',
                'order_id=',
            ];

            $replace = [
                base_url('index.php/user/user/edit?user_token=' . $this->request->getVar('user_token') . '&user_id='),
                base_url('index.php/user/user/edit?user_token=' . $this->request->getVar('user_token') . '&new_user_id='),
                base_url('index.php/catalog/product/edit?user_token=' . $this->request->getVar('user_token') . '&product_id='),
                base_url('index.php/sale/order/edit?user_token=' . $this->request->getVar('user_token') . '&order_id='),

            ];

            $comment = vsprintf(lang('report/activity_log.text_' . $result['key']), unserialize($result['data']));

            $data['activities'][] = [
                'activity_id' => $result['activity_id'],
                'ip'          => $result['ip'],
                'user_agent'  => $result['user_agent'],
                'date_added'  => $result['date_added'],
                'activity'    => str_replace($find, $replace, $comment),
            ];
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['delete'] = base_url('index.php/report/activity/delete?user_token=' . $this->request->getVar('user_token'));

        $this->template->output('report/activity_log', $data);

    }

    



    //--------------------------------------------------------------------
}
