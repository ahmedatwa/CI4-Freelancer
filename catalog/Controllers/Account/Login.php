<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Login extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if ($this->customer->isLogged() && $this->session->get('customer_id')) {
            return redirect('account_dashboard');
        }
        
        $this->template->setTitle(lang('account/login.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/login.heading_title'),
            'href' => route_to('account_login') ? route_to('account_login') : base_url('account/login'),
        ];

        if ($this->session->get('_ci_previous_url') != base_url('account/login')) {
            $this->session->set('redirect_url', $this->session->get('_ci_previous_url'));
        }

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            // Trigger Pusher Online Event
            $options = [
                'cluster' => 'eu',
                'useTLS' => true
            ];

            $pusher = new \Pusher\Pusher(
                'b4093000fa8e8cab989a',
                'fb4bfd2d78aac168d918',
                '1047280',
                $options
            );

            $data['message'] = [
                'customer_id' => $this->customer->getCustomerId(),
                'username' => $this->customer->getCustomerUserName()
            ];

            $pusher->trigger('chat-channel', 'online-event', $data);



            if ($this->session->get('redirect_url')) {
                return redirect()->to($this->session->get('redirect_url'));
            } else {
                return redirect()->to(route_to('account_dashboard') ? route_to('account_dashboard') : base_url('account/dashboard'));
            }
        }
        

        $data['heading_title']  = lang('account/login.heading_title');
        $data['text_login']     = lang('account/login.text_login');
        $data['text_forgotten'] = lang('account/login.text_forgotten');
        $data['text_register']  = sprintf(lang('account/login.text_register'), route_to('acount_register') ? route_to('acount_register') : base_url('account/register'));
        $data['entry_email']    = lang('account/login.entry_email');
        $data['entry_password'] = lang('account/login.entry_password');
        $data['button_login']   = lang('account/login.button_login');


        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if ($this->request->getVar('redirect')) {
            $data['redirect'] = base_url($this->request->getVar('redirect'));
        } else {
            $data['redirect'] = '';
        }

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

        $data['action'] = route_to('account_login') ? route_to('account_login') : base_url('account/login');
        $data['forgotton'] = route_to('account_forgotten') ? route_to('account_forgotten') : base_url('account/forgotten');

        $this->template->output('account/login', $data);
    }

    public function googleAuth()
    {
        $json = [];

        if ($this->request->getVar('id_token') && $this->request->getVar('client_id')) {
            $customerModel = new CustomerModel();

            $client = new \Google_Client([
                'client_id' => $this->request->getVar('client_id'),
            ]);

            $payload = $client->verifyIdToken($this->request->getVar('id_token'));

            if ($payload) {
                if (($payload['aud'] == $this->request->getVar('client_id')) && (in_array($payload['iss'], ['https://accounts.google.com', 'accounts.google.com']))) {
                    $customer_info = $customerModel->where('email', $payload['email'])->first();
                    // user doesn't exist create new one from Client Response
                    if (! $customer_info) {
                        $customer_data = [
                            'customer_group_id' => 1,
                            'online'            => 1,
                            'status'            => 1,
                            'email'             => $payload['email'],
                            'firstname'         => $payload['given_name'],
                            'lastname'          => $payload['family_name'],
                            'username'          => substr($payload['email'], 0, strpos($payload['email'], '@')),
                            'origin'            => 'google',
                        ];

                        $insertID = $customerModel->insert($customer_data);
                    }

                    if ($customer_info) {
                        $session_data = [
                                'customer_id'    => $insertID ?? $customer_info['customer_id'],
                                'customer_image' => $payload['picture'],
                                'customer_name'  => $payload['given_name'] . ' ' . $payload['family_name'],
                                'username'       => substr($payload['email'], 0, strpos($payload['email'], '@')),
                                'gtoken'         => $this->request->getVar('id_token'),
                                'isLogged'       => true,
                            ];

                        $this->session->set($session_data);

                        // Trigger Pusher Online Event
                        $options = ['cluster' => 'eu', 'useTLS' => true];

                        $pusher = new \Pusher\Pusher(
                            'b4093000fa8e8cab989a',
                            'fb4bfd2d78aac168d918',
                            '1047280',
                            $options
                        );

                        $data['message'] = [
                                'customer_id' => $insertID,
                                'username'    => $payload['given_name'] . ' ' . $payload['family_name']
                            ];

                        $pusher->trigger('chat-channel', 'online-event', $data);

                        $json['redirect'] = base_url('account/dashboard');
                    }
                } else {
                    $json['invalid'] = 'Invalid ID token';
                }
            }
        }


        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        // Fields Validation Rules
        if (! $this->validate([
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[4]',
        ])) {
            $this->session->setFlashData('error_warning', lang('account/login.text_warning'));
        }

        $customerModel = new CustomerModel();
        // Check how many login attempts have been made.
        $login_info = $customerModel->getLoginAttempts($this->request->getPost('email'));

        if ($login_info && ($login_info['total'] >= $this->registry->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
            $this->session->setFlashData('error_warning', lang('account/login.error_attempts'));
            return false;
        }
        
        if (!$this->customer->login($this->request->getPost('email'), $this->request->getPost('password'))) {
            $this->session->setFlashData('error_warning', lang('account/login.text_warning'));
            $customerModel->addLoginAttempt($this->request->getPost('email'), $this->request->getIPAddress());
            return false;
        } else {
            $customerModel->deleteLoginAttempts($this->request->getPost('email'));
        }

        return true;
    }

    //--------------------------------------------------------------------
}
