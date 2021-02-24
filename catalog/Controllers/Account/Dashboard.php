<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Account\ActivityModel;
use Catalog\Models\Freelancer\BalanceModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
            return redirect('account_login');
        }

        $this->template->setTitle(lang('account/dashboard.heading_title'));
        
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.list.heading_title'),
            'href' => route_to('account_dashboard'),
        ];

        if ($this->customer->getCustomerId()) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
        }

        $customerModel = new CustomerModel();
        $balanceModel = new BalanceModel();

        if ($customer_id) {
            $customer_info = $customerModel->getCustomer($customer_id);
        }

        // news Feed
        $data['news_feeds'] = [];

        $activityModel = new ActivityModel();

        $results = $activityModel->getActivitiesByCustomerID($customer_id);

        foreach ($results as $result) {
            if (substr($result['key'], 0, 6) != 'admin_') {
                $info = json_decode($result['data'], true);

                $comment = vsprintf(lang('account/activity.list.text_activity_' . $result['key']), $info);

                $username  = '';

                if (isset($info['freelancer_id'])) {
                    $username = $customerModel->where('customer_id', $info['freelancer_id'])->findColumn('username')[0];
                } elseif (isset($info['employer_id'])) {
                    $username = $customerModel->where('customer_id', $info['employer_id'])->findColumn('username')[0];
                }

                $milestone_status = '';

                switch (isset($info['milestone_status'])) {
                    case 0: $milestone_status  = 'Pending'; break;
                    case 1: $milestone_status  = 'Approved'; break;
                    case 2: $milestone_status  = 'Paid'; break;
                    case 3: $milestone_status  = 'Canceled'; break;
                    default: $milestone_status = 'Pending'; break;
                }

                $find = [
                    'url=',
                    'freelancer_id=',
                    'milestone_status=',
                ];

                $replace = [
                    isset($info['url']) ? $info['url'] : '',
                    '@' . $username,
                    $milestone_status,
                ];

                $data['news_feeds'][] = [
                    'comment'    => str_replace($find, $replace, $comment),
                    'date_added' => $this->dateDifference($result['date_added'])
                ];
            }
        }

        $data['total_views']     = $customerModel->getCustomerProfileView($this->customer->getCustomerId());
        $data['total_projects']  = $customerModel->getTotalProjectsByCustomerId($this->customer->getCustomerId());
        $data['total_balance']   = $this->currencyFormat($balanceModel->getBalanceByCustomerID($this->customer->getCustomerId())['total']);
        $data['total_withdrawn'] = $this->currencyFormat($balanceModel->getWithdrawnByCustomerID($this->customer->getCustomerId()));
        $data['total_used']      = $this->currencyFormat($balanceModel->getUsedByCustomerID($this->customer->getCustomerId()));

        $data['text_greeting']  = sprintf(lang('account/dashboard.text_greeting'), $this->session->get('username'));

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $data['langData'] = lang('account/dashboard.list');

        $this->template->output('account/dashboard', $data);
    }

    public function chart()
    {
        $json = [];

        $customerModel = new CustomerModel();

        $results = $customerModel->getBalanceByMonth($this->customer->getCustomerId());

        if ($results) {
            foreach ($results as $key => $value) {
                $json['labels'][]        = $value['month'];
                $json['data']['total'][] =  $value['total'];
            }
        } else {
            $json['labels'][]        = 0;
            $json['data']['total'][] = 0;
        }
    
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
