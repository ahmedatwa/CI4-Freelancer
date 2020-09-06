<?php namespace Admin\Controllers\Extension\Bid;

class Bid extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->bids = new \Admin\Models\Extension\Bid\Bids();

        $this->document->setTitle(lang('extension/bid/bid.list.heading_title'));

        $this->getList();
    }

    protected function getList()
    {

        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extensions?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('extension/bid/bid.list.heading_title'),
            'href' => base_url('index.php/extension/bid/post?user_token=' . $this->session->get('user_token')),
        );

        // Data
        $filter_data = [
            'start' => 0,
            'limit' => $this->registry->get('config_admin_limit'),
         ];
        $data['bids'] = [];
        $results = $this->bids->getBids($filter_data);

        foreach ($results as $result) {
            $data['bids'][] = [
                'bid_id'     => $result['bid_id'],
                'name'       => $result['name'],
                'freelancer' => $result['freelancer'],
                'open'       => $this->getOpenDays($result['date_start'], $result['date_end']),
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'       => base_url('index.php/extension/bid/post/save?user_token=' . $this->session->get('user_token') . '&bid_id=' . $result['bid_id']),
                'delete'     => base_url('index.php/extension/bid/post/delete?user_token=' . $this->session->get('user_token') . '&bid_id=' . $result['bid_id']),
            ];
        }

        $data['add'] = base_url('index.php/extension/bid/post/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/extension/bid/post/delete?user_token=' . $this->session->get('user_token'));
        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=bid');

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

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $this->document->output('extension/bid/bid_list', $data);
    }
        
    //--------------------------------------------------------------------
}
