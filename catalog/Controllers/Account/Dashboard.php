<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Account\ActivityModel;
use \Catalog\Models\Freelancer\BalanceModel;

class Dashboard extends \Catalog\Controllers\BaseController
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
            'text' => lang('account/dashboard.heading_title'),
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
            $info = json_decode($result['data'], true);

            $comment = vsprintf(lang('account/activity.text_activity_' . $result['key']), $info);
            
            $username  = '';

            if (isset($info['freelancer_id'])) {
                $username = $customerModel->where('customer_id', $info['freelancer_id'])->findColumn('username')[0];
            } elseif (isset($info['employer_id'])) {
                $username = $customerModel->where('customer_id', $info['employer_id'])->findColumn('username')[0];
            }

            $milestone_status = '';

            switch (isset($info['milestone_status'])) {
                case 0: $milestone_status = 'Pending'; break;
                case 1: $milestone_status = 'Approved'; break;
                case 2: $milestone_status = 'Paid'; break;
                case 3: $milestone_status = 'Canceled'; break;
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

        $data['profile_views']  = $customerModel->getCustomerProfileView($this->customer->getCustomerId());
        $data['projects_total'] = $customerModel->getTotalProjectsByCustomerId($this->customer->getCustomerId());
        $data['balance']        = $this->currencyFormat($balanceModel->getBalanceByCustomerID($this->customer->getCustomerId()));

        $data['text_dashboard'] = lang('account/dashboard.text_dashboard');
        $data['text_greeting']  = sprintf(lang('account/dashboard.text_greeting'), $this->customer->getCustomerName());
        $data['heading_title']  = lang('account/dashboard.heading_title');
        $data['text_news_feed'] = lang('account/dashboard.text_news_feed');


        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/dashboard', $data);
    }

    public function chart()
    {
        $json = [];

        $customerModel = new CustomerModel();

        $results = $customerModel->getBalanceByMonth($this->customer->getCustomerId());

        foreach ($results as $key => $value) {
            $json['labels'][] = $value['month'];
            $json['data']['total'][] =  $value['total'];
        }

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
