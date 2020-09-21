<?php namespace Catalog\Controllers\Extension\Bid;

class Bid extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $bidModel = new \Catalog\Models\Extension\Bid\BidModel();

        $data['heading_title'] = lang('extension/bid/bid.heading_title');

        if ($this->request->getVar('project_id')) {
            $project_id = $this->request->getVar('project_id');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = 6;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
            'orderBy'    => 'p.date_added',
            'sortBy'     => 'DESC',
            'project_id' => $project_id,
            'limit'      => $limit,
            'start'      => ($page - 1) * $limit,
         ];

        $data['bids'] = [];

        $results = $bidModel->getBids($filter_data);
        $bids_total = $bidModel->getTotalBids($filter_data);
        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();
        foreach ($results as $result) {
            $data['bids'][] = [
                'bid_id'     => $result['bid_id'],
                'freelancer' => $result['freelancer'],
                'quote'      => $this->currencyFormat($result['quote']),
                'delivery'   => $result['delivery'] . ' ' . lang($this->locale . '.text_days'),
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'profile'    => route_to('customer_profile', $result['customer_id']),
                'image'      => ($result['image']) ? $this->resize($result['image'], 80, 80) : $this->resize('catalog/avatar.jpg', 80, 80),
                'rating'     => $reviewModel->getAvgReviewByFreelancerId($result['freelancer_id'])
            ];
        }

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $bids_total);

        return view('extension/bid/bid', $data);
    }
       
    public function placeBid()
    {
        $json = [];

        if ($this->request->getPost('employer_id') == $this->request->getPost('freelancer_id')) {
            $json['error'] = lang('project/project.text_error_bid');
        }

        if (!$this->customer->isLogged()) {
            $json['error'] = sprintf(lang('project/project.text_login_error'), route_to('account/login'));
        }

        if (!$json) {
            if ($this->request->getPost('project_id') || $this->request->getPost('freelancer_id')) {
                $bidModel = new \Catalog\Models\Extension\Bid\BidModel();

                $data = [
                'project_id'    => $this->request->getPost('project_id'),
                'freelancer_id' => $this->request->getPost('freelancer_id'),
                'quote'         => $this->request->getPost('quote'),
                'delivery'      => $this->request->getPost('delivery'),
                'status' => 1,
               ];

                if (($this->request->getMethod() == 'post')) {
                    $bidModel->insert($data);
                    $json['success'] = lang('project/project.text_success');
                }
            }
        }


        return $this->response->setJSON($json);
    }
    //--------------------------------------------------------------------
}
