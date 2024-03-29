<?php namespace Admin\Controllers\Customer;

use \Admin\Models\Customer\CustomerGroupModel;
use \Admin\Models\Localisation\LanguageModel;

class Customer_group extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $customerGroupModel = new CustomerGroupModel();

        $this->document->setTitle(lang('customer/customer_group.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('customer/customer_group.list.text_add'));

        $customerGroupModel = new CustomerGroupModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $customerGroupModel->addCustomerGroup($this->request->getPost());
            return redirect()->to(base_url('index.php/customer/customer_group?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('customer/customer_group.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('customer/customer_group.list.text_edit'));

        $customerGroupModel = new CustomerGroupModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $customerGroupModel->editCustomerGroup($this->request->getVar('customer_group_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/customer/customer_group?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('customer/customer_group.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $customersGroupModel = new CustomerGroupModel();
   
        $this->document->setTitle(lang('customer/customer_group.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $customer_group_id) {
                $customerGroupModel->deleteCustomerGroup($customer_group_id);
                $json['success'] = lang('customer/customer_group.text_success');
                $json['redirect'] = 'index.php/customer/customer_group?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('user/user.error_permission');
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
            'text' => lang('customer/customer_group.list.heading_title'),
            'href' => base_url('index.php/customer/customer_group?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $filter_data = [
            'start' => 0,
            'limit' => $this->registry->get('config_admin_limit'),
        ];

        $data['customer_groups'] = [];

        $customerGroupModel = new CustomerGroupModel();

        $results = $customerGroupModel->getCustomerGroups($filter_data);

        foreach ($results as $result) {
            $data['customer_groups'][] = [
                'customer_group_id' => $result['customer_group_id'],
                'name'              => $result['name'],
                'sort_order'        => $result['sort_order'],
                'edit'              => base_url('index.php/customer/customer_group/edit?user_token=' . $this->request->getVar('user_token') . '&customer_group_id=' . $result['customer_group_id']),
            ];
        }

        $data['add'] = base_url('index.php/customer/customer_group/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/customer/customer_group/delete?user_token=' . $this->request->getVar('user_token'));

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

        $this->document->output('customer/customer_group_list', $data);
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
            'text' => lang('customer/customer_group.list.heading_title'),
            'href' => base_url('index.php/customer/customer_group/save?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('customer_group_id') ? lang('customer/customer_group.list.text_add') : lang('customer/customer_group.list.text_edit');

        $data['cancel'] = base_url('index.php/customer/customer_group?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('customer_group_id')) {
            $data['action'] = base_url('index.php/customer/customer_group/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/customer/customer_group/edit?user_token=' . $this->request->getVar('user_token') . '&customer_group_id=' . $this->request->getVar('customer_group_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $customerGroupModel = new CustomerGroupModel();

        if ($this->request->getVar('customer_group_id') && ($this->request->getMethod() != 'post')) {
            $customer_group_info = $customerGroupModel->getCustomerGroup($this->request->getVar('customer_group_id'));
        }

        if ($this->request->getPost('customer_group_description')) {
            $data['customer_group_description'] = $this->request->getPost('customer_group_description');
        } elseif ($this->request->getVar('customer_group_id')) {
            $data['customer_group_description'] = $customerGroupModel->getCustomerGroupDescriptions($this->request->getVar('customer_group_id'));
        } else {
            $data['customer_group_description'] = [];
        }
        
        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($customer_group_info)) {
            $data['sort_order'] = $customer_group_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        $languageModel = new LanguageModel();
        $data['languages'] = $languageModel->where('status', 1)->findAll();


        $this->document->output('customer/customer_group_form', $data);
    }

    protected function validateForm()
    {
        foreach ($this->request->getPost('customer_group_description') as $language_id => $value) {
            if (! $this->validate([
            "customer_group_description.{$language_id}.name" => [
                'label' => 'Group Name',
                'rules' => 'required|min_length[3]'
            ],
        ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', 'customer/customer_group')) {
            $this->session->setFlashdata('error_warning', lang('customer/customer_group.error_permission'));
            return false;
        }
        return true;
    }
    
    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'customer/customer_group')) {
            $this->session->setFlashdata('error_warning', lang('customer/customer_group.error_permission'));
            return false;
        }
        return true;
    }

    //--------------------------------------------------------------------
}
