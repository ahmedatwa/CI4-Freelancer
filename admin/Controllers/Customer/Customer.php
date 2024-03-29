<?php namespace Admin\Controllers\Customer;

use \Admin\Models\Customer\CustomerModel;
use \Admin\Models\Customer\CustomerGroupModel;
use \Extensions\Models\Wallet\WalletModel;

class Customer extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $customerModel = new customerModel();

        $this->document->setTitle(lang('customer/customer.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('customer/customer.list.text_add'));

         $customerModel = new customerModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $customerModel->insert($this->request->getPost());
            return redirect()->to(base_url('index.php/customer/customer?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('customer/customer.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('customer/customer.list.text_edit'));

         $customerModel = new customerModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $customerModel->update($this->request->getVar('customer_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/customer/customer?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('customer/customer.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

         $customerModel = new customerModel();
   
        $this->document->setTitle(lang('customer/customer.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $customer_id) {
                $customerModel->deleteCustomer($customer_id);
                $json['success'] = lang('customer/customer.text_success');
                $json['redirect'] = 'index.php/customer/customer?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('customer/customer.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('customer/customer.list.heading_title'),
            'href' => base_url('index.php/customer/customer?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $filter_data = [
            'start' => 0,
            'limit' => $this->registry->get('config_admin_limit'),
        ];

        $data['customers'] = [];
        $customerModel = new customerModel();
        $results = $customerModel->getcustomers($filter_data);

        foreach ($results as $result) {
            $data['customers'][] = [
                'customer_id'    => $result['customer_id'],
                'name'           => $result['name'],
                'email'          => $result['email'],
                'customer_group' => $result['customer_group'],
                'ip'             => $result['ip'],
                'date_added'     => DateShortFormat($result['date_added']),
                'status'         => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'           => base_url('index.php/customer/customer/edit?user_token=' . $this->request->getVar('user_token') . '&customer_id=' . $result['customer_id']),
                'delete'         => base_url('index.php/customer/customer/delete?user_token=' . $this->request->getVar('user_token') . '&customer_id=' . $result['customer_id']),
            ];
        }

        $data['add'] = base_url('index.php/customer/customer/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/customer/customer/delete?user_token=' . $this->request->getVar('user_token'));

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

        $this->document->output('customer/customer_list', $data);
    }

    protected function getForm()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('customer/customer.list.heading_title'),
            'href' => base_url('index.php/customer/customer/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('customer_id') ? lang('customer/customer.list.text_add') : lang('customer/customer.list.text_edit');

        $data['cancel'] = base_url('index.php/customer/customer?user_token=' . $this->request->getVar('user_token'));

        $data['user_token'] = $this->request->getVar('user_token');

        if (!$this->request->getVar('customer_id')) {
            $data['action'] = base_url('index.php/customer/customer/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/customer/customer/edit?user_token=' . $this->request->getVar('user_token') . '&customer_id=' . $this->request->getVar('customer_id'));
        }

        if ($this->session->get('error_warning')) {
            $data['error_warning'] = $this->session->get('error_warning');
        } else {
            $data['error_warning'] = '';
        }

         $customerModel = new customerModel();

        if ($this->request->getVar('customer_id') && ($this->request->getMethod() != 'post')) {
            $customer_info = $customerModel->find($this->request->getVar('customer_id'));
        }

        if (!empty($customer_info['customer_id'])) {
            $data['customer_id'] = $customer_info['customer_id'];
        } else {
            $data['customer_id'] = $this->request->getVar('customer_id');
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif (!empty($customer_info)) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif (!empty($customer_info)) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        } elseif (!empty($customer_info)) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('telephone')) {
            $data['telephone'] = $this->request->getPost('telephone');
        } elseif (!empty($customer_info)) {
            $data['telephone'] = $customer_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if ($this->request->getPost('confirm')) {
            $data['confirm'] = $this->request->getPost('confirm');
        } else {
            $data['confirm'] = '';
        }

        // UserGroup
        $CustomerGroupModel = new CustomerGroupModel();

        $data['customer_groups'] = $CustomerGroupModel->getCustomerGroups();
        
        if ($this->request->getPost('customer_group_id')) {
            $data['customer_group_id'] = $this->request->getPost('customer_group_id');
        } elseif (!empty($customer_info)) {
            $data['customer_group_id'] = $customer_info['customer_group_id'];
        } else {
            $data['customer_group_id'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($customer_info)) {
            $data['status'] = $customer_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($this->request->getPost('newsletter')) {
            $data['newsletter'] = $this->request->getPost('newsletter');
        } elseif (!empty($customer_info)) {
            $data['newsletter'] = $customer_info['newsletter'];
        } else {
            $data['newsletter'] = 0;
        }

        $this->document->output('customer/customer_form', $data);
    }

    public function review()
    {
        $customerModel = new customerModel();

        $data['column_project']    = lang('catalog/review.list.column_project');
        $data['column_employer']   = lang('catalog/review.list.column_employer');
        $data['column_freelancer'] = lang('catalog/review.list.column_freelancer');
        $data['column_rated_by']   = lang('catalog/review.list.column_rated_by');
        $data['column_rating']     = lang('catalog/review.list.column_rating');
        $data['column_status']     = lang('catalog/review.list.column_status');
        $data['column_action']     = lang('en.list.column_action');

        $data['entry_rated_by']    = lang('catalog/review.list.entry_rated_by'); 

        $data['button_approve']    = lang('en.list.button_approve');
        $data['button_view']       = lang('en.list.button_view');

        $filter_data = [
            'customer_id' => $this->request->getVar('customer_id') ?? 0,
            'start' => 0,
            'limit' => 5,
        ];

        $data['reviews'] = [];
        $results = $customerModel->getReviews($filter_data);

        foreach ($results as $result) {

            $data['reviews'][] = [
                'review_id'    => $result['review_id'],
                'name'         => $result['name'],
                'employer'     => $customerModel->where('customer_id', $result['employer_id'])->findColumn('username')[0],
                'freelancer'   => $customerModel->where('customer_id', $result['freelancer_id'])->findColumn('username')[0],
                'submitted_by' => $customerModel->where('customer_id', $result['submitted_by'])->findColumn('username')[0],
                'rating'       => $result['rating'],
                'status'       => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'approve'      => base_url('index.php/customer/customerModel/approve?user_token=' . $this->request->getVar('user_token') . '&review_id=' . $result['review_id']),
                'view'         => base_url('index.php/catalog/review/edit?user_token=' . $this->request->getVar('user_token') . '&review_id=' . $result['review_id']),

            ];
        }
        
        return view('customer/customer_review', $data);
    }

    public function wallet()
    {
        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } else {
            $customer_id = 0;
        }

        $walletModel = new WalletModel();
        $customerModel = new customerModel();

        $data['column_income']    = lang('extension/wallet.list.column_income');
        $data['column_withdrawn'] = lang('extension/wallet.list.column_withdrawn');
        $data['column_available'] = lang('extension/wallet.list.column_available');
        $data['column_date_added'] = lang('extension/wallet.list.column_date_added');
        $data['column_used']      = lang('extension/wallet.list.column_used');
        $data['column_action']    = lang('en.list.column_action');

        $data['wallets'] = [];

        $results = $walletModel->where('customer_id', $customer_id)->findAll();
        $income = 0;
        $withdrawn = 0;
        $used = 0;
        $available = 0;

        foreach ($results as $result) {
            $income    += $result['income'];
            $withdrawn += $result['withdrawn'];
            $used      += $result['used'];
            $available += $result['available'];

            $data['wallets'][] = [
                'income'     => $result['income'],
                'withdrawn'  => $result['withdrawn'],
                'used'       => $result['used'],
                'available'  => ($available + $income) - ($withdrawn + $used),
                'date_added' => DateShortFormat($result['date_added']),
            ];
        }
        
        return view('customer/customer_wallet', $data);
    }

    public function autocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_name')) {
             $customerModel = new customerModel();

            if ($this->request->getVar('filter_name')) {
                $filter_name = html_entity_decode($this->request->getVar('filter_name'), ENT_QUOTES, 'UTF-8');
            } else {
                $filter_name = null;
            }

            $filter_data = [
                'filter_name' => $filter_name,
                'start' => 0,
                'limit' => 5,
            ];

            $results = $customerModel->getcustomerModel($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'customer_id' => $result['customer_id'],
                    'name'        => $result['name']
                ];
            }
        }

        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        if (! $this->request->getVar('customer_id')) {
            if (! $this->validate([
                    'firstname' => 'required|alpha_numeric_space|min_length[3]',
                    'lastname'  => 'required|alpha_numeric_space|min_length[3]',
                    'email'     => 'required|valid_email|is_unique[customer.email,customer_id,{customer_id}]',
                    'password'  => 'required|min_length[4]',
                    'confirm'   => 'required_with[password]|matches[password]',
                    ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        } else {
            if (! $this->validate([
                    'firstname' => 'required|alpha_numeric_space|min_length[3]',
                    'lastname'  => 'required|alpha_numeric_space|min_length[3]',
                    'email'     => 'required|valid_email|is_unique[customer.email,customer_id,{customer_id}]',
                    ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('customer/customer.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('customer/customer.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
