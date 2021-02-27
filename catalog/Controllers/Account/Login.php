<?php

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Account\ActivityModel;

class Login extends BaseController
{
    public function index()
    {
        if ($this->customer->isLogged()) {
            return redirect()->to(route_to('account_dashboard', $this->customer->getUserName()));
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

        $data['text_register']  = sprintf(lang('account/login.text_register'), route_to('acount_register') ? route_to('acount_register') : base_url('account/register'));
        $data['forgotton'] = route_to('account_forgotten') ? route_to('account_forgotten') : base_url('account/forgotten');

        $data['langData'] = lang('account/login.list');
        
        $this->template->output('account/login', $data);
    }

    public function authLogin()
    {
        $json = [];

        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            $customerModel = new CustomerModel();

            if (! $this->validate([
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[4]',
            ])) {
                $json['error_warning'] = lang('account/login.text_warning');
                $json['validator'] = $this->validator->getErrors() ?? 'false';
            }

            // 2-step verification
            if (! $json && $this->customer->checkTwoStepVerification($this->request->getPost('email', FILTER_SANITIZE_EMAIL))) {
                $this->customer->editAccessCode($this->request->getPost('email', FILTER_SANITIZE_EMAIL), random_string('numeric', 7));
                $json['redirect'] = route_to('account_verify');
            } else {
                // Check how many login attempts have been made.
                $login_info = $customerModel->getLoginAttempts($this->request->getPost('email', FILTER_SANITIZE_EMAIL));

                if ($login_info && ($login_info['total'] >= $this->registry->get('config_login_attempts')) && strtotime('-1 hour') < $login_info['date_modified']) {
                    $json['error_attempts'] = lang('account/login.error_attempts');
                }

                if (! $this->customer->login($this->request->getPost('email', FILTER_SANITIZE_EMAIL), $this->request->getPost('password', FILTER_SANITIZE_STRING))) {
                        $json['error_warning'] = lang('account/login.text_warning');
                        $customerModel->addLoginAttempt($this->request->getPost('email', FILTER_SANITIZE_EMAIL), $this->request->getIPAddress());
                }
            }

            if (! $json) {
                $customerModel->deleteLoginAttempts($this->request->getPost('email', FILTER_SANITIZE_EMAIL));
                /**
                * Register Login Event...for extra future security use
                * Like trigger notification email for user if user_agent changed or IP or blocked IPs
                * Admin will be registered with the same event for more info.
                */
                $customer_info = $customerModel->find($this->session->get('customer_id'));

                \CodeIgniter\Events\Events::trigger('customer_login', $customer_info['customer_id'], $customer_info['username']);

                $activityModel = new ActivityModel;
                $customer_ip_info = $activityModel->getCustomerIP($this->session->get('customer_id'));
                // Fire the Event if IP is not recognized
                if ($customer_ip_info['ip'] && ($this->request->getIPAddress() != $customer_ip_info['ip'])) {
                    $agent = $this->request->getUserAgent();
                    $ip_data = [
                        'customer_id' => $this->session->get('customer_id'),
                        'browser'     => $agent->getBrowser() . ' ' . $agent->getVersion(),
                        'platform'    => $agent->getPlatform(),
                    ];
                    // Trigger Customer E-Mail as IP is different than usual one..
                    \CodeIgniter\Events\Events::trigger('customer_login_notify', $ip_data);
                }

                // check for any saved redirect url
                if ($this->session->get('redirect_url')) {
                    $json['redirect'] = (string) $this->session->get('redirect_url');
                } elseif (! is_null($this->request->getCookie(config('App')->cookiePrefix . 'redirect_url'))) {
                    $json['redirect'] = base64_decode($this->request->getCookie(config('App')->cookiePrefix . 'redirect_url', FILTER_SANITIZE_STRING));
                } else {
                    $json['redirect'] = route_to('account_dashboard', $this->session->get('username'));
                }
            }
        }
       
        return $this->response->setJSON($json);
    }

    public function googleAuth()
    {
        $json = [];

        if (($this->request->getMethod() == 'post') && $this->request->isAJAX()) {
            if ($this->request->getPost('id_token') && $this->request->getPost('client_id')) {
                $customerModel = new CustomerModel();

                $client = new \Google_Client([
                'client_id' => $this->request->getPost('client_id'),
            ]);

                $payload = $client->verifyIdToken($this->request->getPost('id_token'));

                if ($payload) {
                    if (($payload['aud'] == $this->request->getPost('client_id')) && (in_array($payload['iss'], ['https://accounts.google.com', 'accounts.google.com']))) {
                        $customer_info = $customerModel->where('email', $payload['email'])->first();
                        // user doesn't exist create new one from Client Response
                        if (! $customer_info) {
                            $customerData = [
                                'customer_group_id' => 1,
                                'online'            => 1,
                                'status'            => 1,
                                'email'             => $payload['email'],
                                'firstname'         => $payload['given_name'],
                                'lastname'          => $payload['family_name'],
                                'username'          => substr($payload['email'], 0, strpos($payload['email'], '@')),
                                'origin'            => 'google',
                            ];

                            $insertID = $customerModel->insert($customerData);
                        }

                        if ($customer_info) {
                            $sessionData = [
                                'customer_id'    => $insertID ?? $customer_info['customer_id'],
                                'customer_image' => $payload['picture'],
                                'customer_name'  => $payload['given_name'] . ' ' . $payload['family_name'],
                                'username'       => substr($payload['email'], 0, strpos($payload['email'], '@')),
                                'gtoken'         => $this->request->getVar('id_token'),
                                'isLogged'       => true,
                            ];

                            $this->session->set($sessionData);
                            // Trigger Pusher Online Event
                            $options = ['cluster' => PUSHER_CLUSTER, 'useTLS' => PUSHER_USETLS];
                            $pusher = new \Pusher\Pusher(PUSHER_KEY, PUSHER_SECRET, PUSHER_APP_ID, $options);
                            $data['message'] = [
                                'customer_id' => $insertID ?? $customer_info['customer_id'],
                                'username'    => $payload['given_name'] . ' ' . $payload['family_name']
                            ];

                            $pusher->trigger('chat-channel', 'online-event', $data);
                        }
                        $json['redirect'] = base_url('account/dashboard');
                    } else {
                        $json['error'] = 'Unable to verifiy ID token';
                    }
                }
            } else {
                $json['error'] = 'Invalid ID token or Client ID';
            }
        }
        
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
