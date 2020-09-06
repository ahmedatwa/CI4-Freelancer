<?php namespace Admin\Controllers\Report;

class Activity extends \Admin\Controllers\BaseController
{
    protected $activityModel;

    public function index()
    {
        $this->activityModel = new \Admin\Models\Report\Activity();

        $data['textHeading'] = lang('report/activity_log.textHeading');

        $this->getList();

    }

    public function getList()
    {
        $data['delete'] = '';

        if ($this->session->get('success')) {
            $data['success'] = $this->session->get('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->get('error')) {
            $data['error'] = $this->session->get('error');
        } else {
            $data['error'] = '';
        }

        $data['activities'] = array();

        $total_activities = $this->activityModel->getTotalActivities();
        $results          = $this->activityModel->getActivities();

        foreach ($results as $result) {
            $find = array(
                'user_id=',
                'product_id=',
                'new_user_id=',
                'order_id=',
            );

            $replace = array(
                base_url('index.php/user/user/edit?user_token=' . $this->session->get('user_token') . '&user_id='),
                base_url('index.php/user/user/edit?user_token=' . $this->session->get('user_token') . '&new_user_id='),
                base_url('index.php/catalog/product/edit?user_token=' . $this->session->get('user_token') . '&product_id='),
                base_url('index.php/sale/order/edit?user_token=' . $this->session->get('user_token') . '&order_id='),

            );

            $comment = vsprintf(lang('report/activity_log.text_' . $result['key']), unserialize($result['data']));

            $data['activities'][] = array(
                'activity_id' => $result['activity_id'],
                'ip'          => $result['ip'],
                'user_agent'  => $result['user_agent'],
                'date_added'  => $result['date_added'],
                'activity'    => str_replace($find, $replace, $comment),
            );
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = array();
        }

        $data['delete'] = base_url('index.php/report/activity/delete?user_token=' . $this->session->get('user_token'));


        $this->template->output('report/activity_log', $data);

    }

    



    //--------------------------------------------------------------------
}
