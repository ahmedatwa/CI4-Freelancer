<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Account\ActivityModel;

class Dashboard extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged() ) {
             return redirect('account_login');
        }

        $this->template->setTitle(lang('account/dashboard.heading_title'));
        
        if($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => route_to('account_dashboard'),
        ];

        $customerModel = new CustomerModel();

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

            $find = [
                'project_id=',
                'employer_id=',
                'freelancer_id=',
            ];

            $seo_url = service('seo_url');
            $keyword = $seo_url->getKeywordByQuery('project_id=' . $info['project_id']);

            if (isset($info['employer_id'])) {
               $employer = $activityModel->getEmployerUserName($info['employer_id']);
            }

            if (isset($info['freelancer_id'])) {
                $freelancer = $activityModel->getFreelancerUserName($info['freelancer_id']);
            }

            $replace = [
                'service/' . $keyword,
                $employer['username'] ?? '',
                $freelancer['username'] ?? '',
            ];


            $data['news_feeds'][] = [
                'comment'    => str_replace($find, $replace, $comment),
                'date_added' => $this->dateDifference($result['date_added'])
            ];
        }

        $data['profile_views']  = $customerModel->getCustomerProfileView($customer_id);
        $data['projects_total'] = $customerModel->getTotalProjectsByCustomerId($customer_id);
        $data['balance']        = $this->currencyFormat($customerModel->getBalanceByCustomerID($customer_id));

        $data['text_dashboard'] = lang('account/dashboard.text_dashboard');
        $data['text_greeting']  = sprintf(lang('account/dashboard.text_greeting'), $this->customer->getCustomerName());
        $data['heading_title']  = lang('account/dashboard.heading_title');
        $data['text_news_feed'] = lang('account/dashboard.text_news_feed');


        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/dashboard', $data);
    }

    //--------------------------------------------------------------------
}
