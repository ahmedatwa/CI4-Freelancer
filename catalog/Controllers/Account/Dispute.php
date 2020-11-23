<?php namespace Catalog\Controllers\Account;

use \Catalog\Models\Catalog\ProjectModel;
use \Catalog\Models\Localization\ProjectStatusModel;

class Dispute extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
            return redirect('account_login');
        }

        $projectModel = new ProjectModel();

        $this->template->setTitle(lang('account/dispute.heading_title'));
            
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => base_url('account/dashboard'),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dispute.heading_title'),
            'href' => base_url('account_project'),
        ];

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

        $data['heading_title'] = lang('account/dispute.heading_title');
        $data['customer_id'] = $customer_id;
        
        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/dispute', $data);
    }

    //--------------------------------------------------------------------
}
