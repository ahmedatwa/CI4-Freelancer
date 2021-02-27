<?php 

namespace Extensions\Controllers\Bid;

use Admin\Controllers\BaseController;
use Extensions\Models\Bid\BidModel;

class Bid extends BaseController
{
    public function index()
    {
        $bidsModel = new BidModel();

        $this->document->setTitle(lang('bid/bid.list.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extensions?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('bid/bid.list.heading_title'),
            'href' => base_url('index.php/bid?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $filter_data = [
            'start' => 0,
            'limit' => $this->registry->get('config_admin_limit'),
         ];
        $data['bids'] = [];
        $results = $bidsModel->getBids($filter_data);

        foreach ($results as $result) {
            $data['bids'][] = [
                'bid_id'     => $result['bid_id'],
                'name'       => $result['name'],
                'freelancer' => $result['freelancer'],
                'delivery'   => $result['delivery'],
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'       => base_url('index.php/bid/edit/save?user_token=' . $this->request->getVar('user_token') . '&bid_id=' . $result['bid_id']),
                'delete'     => base_url('index.php/bid/delete/delete?user_token=' . $this->request->getVar('user_token') . '&bid_id=' . $result['bid_id']),
            ];
        }

        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=bid');

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

        $data['heading_title']     = lang('bid/bid.heading_title');
        $data['text_list']         = lang('bid/bid.text_list');
        $data['column_name']       = lang('bid/bid.column_name');
        $data['column_freelancer'] = lang('bid/bid.column_freelancer');
        $data['column_delivery']   = lang('bid/bid.column_delivery');
        $data['column_status']     = lang('en.column_status');
        $data['column_action']     = lang('en.column_action');
        $data['button_cancel']     = lang('en.button_cancel');

        $this->document->moduleOutput('Extensions', 'bid\bid_list', $data);
    }
        
    //--------------------------------------------------------------------
}
