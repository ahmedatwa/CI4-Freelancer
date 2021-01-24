<?php namespace Catalog\Controllers\Extension\Bid;

use \Catalog\Models\Extension\Bid\BidModel;
use \Catalog\Models\Freelancer\BalanceModel;
use \Catalog\Models\Account\ReviewModel;

class Bid extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $bidModel = new BidModel();

        $data['heading_title'] = lang('extension/bid/bid.heading_title');

        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } elseif ($this->request->getGet('project_id')) {
            $project_id = $this->request->getGet('project_id');
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
            'project_id' => $project_id,
            'limit'      => $limit,
            'start'      => ($page - 1) * $limit,
         ];

        $data['bids'] = [];

        $results = $bidModel->getBids($filter_data);
        $total = $bidModel->getTotalBids($filter_data);
        $reviewModel = new ReviewModel();

        foreach ($results as $result) {
            $data['bids'][] = [
                'bid_id'     => $result['bid_id'],
                'freelancer' => $result['username'],
                'quote'      => $this->currencyFormat($result['quote'], 0),
                'description' => nl2br($result['description']),
                'delivery'   => $result['delivery'] . ' ' . lang($this->locale . '.text_days'),
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'profile'    => route_to('customer_profile', $result['customer_id']),
                'image'      => (file_exists('images/' . $result['image'])) ? $this->resize($result['image'], 80, 80) : $this->resize('catalog/avatar.jpg', 80, 80),
                'rating'     => $reviewModel->getAvgReviewByFreelancerId($result['freelancer_id'])
            ];
        }

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        return view('extension/bid/bid', $data);
    }
       
    public function placeBid()
    {
        $json = [];

        if (! $this->validate([
            'quote'         => "required",
            'description'   => "required",
            'delivery'      => 'required|numeric',
        ])) {
            $json['error'] = $this->validator->getErrors();
        }

        $balanceModel = new BalanceModel();

        $balance = $balanceModel->getBalanceByCustomerID($this->customer->getCustomerId());

        // Employer Balance Validation
        if (!empty($this->request->getPost('fee'))) {
            if (($balance == 0) || $this->request->getPost('fee') > $balance) {
                $json['fee'] = sprintf(lang('freelancer/freelancer.error_balance'), route_to('freelancer_deposit'));
            }
        }

        $bidModel = new BidModel();

        $isUnique = $bidModel->uniqueBid($this->customer->getCustomerId(), $this->request->getPost('project_id'));

        if ($isUnique) {
            $json['no_allawed'] = lang('freelancer/freelancer.error_unique');
        }

        if (!$json) {
            if ($this->request->getPost('project_id') || $this->request->getPost('freelancer_id')) {
                $bidModel = new BidModel();

                if (($this->request->getMethod() == 'post')) {
                    $bidModel->addBid($this->request->getPost());
                    $json['success'] = lang('project/project.text_success');
                }
            }
        }

        return $this->response->setJSON($json);
    }
    //--------------------------------------------------------------------
}
