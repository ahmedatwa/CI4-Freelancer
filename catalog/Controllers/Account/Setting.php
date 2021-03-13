<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Localization\CountryModel;

class Setting extends BaseController
{
    public function edit()
    {
        $this->template->setTitle(lang('account/setting.heading_title'));

        $customerModel = new CustomerModel();

        if (($this->request->getMethod() == 'post')) {
            $customerModel->update($this->session->get('customer_id'), $this->request->getPost());
            return redirect('account_setting')->with('success', lang('account/setting.text_success'));
        }

        $this->index();
    }

    public function index(string $username = '')
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
            return redirect('account_login');
        }

        $this->template->setTitle(lang('account/setting.heading_title'));

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->customer->getID();
        } else {
            $customer_id = 0;
        }

        $customerModel = new CustomerModel();

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => route_to('account_dashboard', $username),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/setting.heading_title'),
            'href' => route_to('account_setting', $username),
        ];


        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($customer_id) {
            $customer_info = $customerModel->find($customer_id);
        }

        if (isset($customer_info['firstname'])) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if (isset($customer_info['lastname'])) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if (isset($customer_info['email'])) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($customer_info['two_step']) {
            $data['two_step'] = $customer_info['two_step'];
        } else {
            $data['two_step'] = 0;
        }

        if ($this->request->getPost('username')) {
            $data['username'] = strtolower($this->request->getPost('username'));
        } elseif ($customer_info['username']) {
            $data['username'] = $customer_info['username'];
        } else {
            $data['username'] = '';
        }

        // avatar placeholder
        if (!empty($customer_info['image']) && file_exists(DIR_IMAGE . $customer_info['image'])) {
            $thumb = '<img src="images/' . $customer_info['image'] . '" style="height:260px;" alt="Your Avatar">';
        } else {
            $thumb = '<img src="images/catalog/avatar.jpg" style="height:260px;"alt="Your Avatar"><h6 class="text-muted">Click to select</h6>';
        }

        $data['thumb'] = $thumb;

        // Background image placeholder
        if (!empty($customer_info['bg_image']) && file_exists(DIR_IMAGE . $customer_info['bg_image'])) {
            $bg_thumb = '<img src="images/'. $customer_info['bg_image'] . '" style="height:260px;width:100%;" alt="Your Profile Background Image">';
        } else {
            $bg_thumb = '<img src="images/no_image.jpg" style="height:260px;width:100%;" alt="Your Avatar">';
        }
        
        $data['bg_thumb'] = $bg_thumb;

        $data['action'] = base_url('account/setting/edit?customer_id=' . $this->customer->getID());

        // Country
        $countryModel = new CountryModel();
        $data['countries'] = $countryModel->where('status', 1)->findAll();

        $data['customer_id'] = $this->customer->getID();
        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');
        $data['currency'] = $this->session->get('currency') ?? $this->registry->get('config_currency');

        $data['langData'] = lang('account/setting.list');
        
        $this->template->output('account/setting', $data);
    }

    public function backgroundImageUpload()
    {
        $json = [];
        if ($this->request->isAJAX()) {
            if ($imagefile = $this->request->getFile('bg_image')) {
                $customerModel = new CustomerModel();

                if ($imagefile->isValid() && ! $imagefile->hasMoved()) {
                    $newName = $imagefile->getRandomName();
                    $imagefile->move('images/catalog', $newName);
                    $customerModel->where('customer_id', $this->session->get('customer_id'))
                              ->set('bg_image', 'catalog/' . $newName)
                              ->update();
                    // return fileInput Config
                    $json = [
                        'initialPreview' => base_url('images/catalog/' . $newName),
                        'initialPreviewConfig' => [
                            'caption' => $imagefile->getClientName(),
                            'url'     => '',
                            'key'     => $this->session->get('customer_id'),
                        ],
                        'append' => true,
                   ];
                }
            }
        }
        return $this->response->setJSON($json);
    }

    public function password()
    {
        $json = [];
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            // Fields Validation Rules // Passowrd Update
            if ($this->request->getPost('current') && $this->request->getPost('password')) {
                if (! $this->validate([
                        'current'  => 'required',
                        'password' => 'required|min_length[4]|alpha_numeric_punct',
                        'confirm'  => 'required_with[password]|matches[password]',
                    ])) {
                    $json['error'] = $this->validator->getErrors();
                }

                if (! $json) {
                    $customerModel = new CustomerModel();

                    $oldPassword = $customerModel->where('customer_id', $this->customer->getID())
                                                 ->findColumn('password');
                    if (password_verify($this->request->getPost('current'), $oldPassword[0])) {
                        // old password passed then update
                        $customerModel->where('customer_id', $this->customer->getID())
                                      ->set('password', $this->request->getPost('password'))
                                      ->update();
                        $json['success'] = lang('account/setting.text_password_success');
                    } else {
                        $json['error']['old_password'] = lang('account/setting.error_old_password');
                    }
                }
            } 
        }
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
