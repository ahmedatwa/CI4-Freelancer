<?php

namespace Install\Controllers;

use CodeIgniter\Controller;
use Install\Libraries\Document;
use \Install\Models\InstallModel;

class Step_2 extends Controller
{
    protected $error = [];

    public function index()
    {
        $document = new Document();

        if (($this->request->getMethod(true) == 'POST') && $this->validateForm()) {
            if ($this->checkDBConn($this->request->getPost())) {
               $installModel = new InstallModel();
            
                $installModel->database($this->request->getPost());

                // // Catalog App.php
                $catalogAppFile = ROOTPATH . 'catalog/Config/App.php' . DIRECTORY_SEPARATOR;

                if (is_file($catalogAppFile)) {
                    $getAppFileContents = file_get_contents($catalogAppFile);

                    $baseURLString = str_replace(["http://ci4.localhost/", "http://ci4.localhost/admin/"], [BASE_URL, BASE_URL . 'admin/'], $getAppFileContents);

                    file_put_contents($catalogAppFile, $baseURLString);
                }
                // -----------------------
                // catalog BD
                $catalogDbFile = ROOTPATH . 'catalog/Config/Database.php' . DIRECTORY_SEPARATOR;

                if (is_file($catalogDbFile)) {
                    $getDBFileContents = file_get_contents($catalogDbFile);

                    $oldDBVars = [
                        'hostname' => '127.0.0.1',
                        'username' => 'root',
                        'password' => '',
                        'database' => 'ci4',
                        'DBPrefix' => 'ci_',
                        'port'     => 3306,
                    ];

                    $newDBVars = [
                        'hostname' => $this->request->getPost('db_hostname'),
                        'username' => $this->request->getPost('db_username'),
                        'password' => $this->request->getPost('db_password'),
                        'database' => $this->request->getPost('db_database'),
                        'DBPrefix' => $this->request->getPost('db_prefix'),
                        'port'     => $this->request->getPost('db_port'),
                    ];

                    $dbString = str_replace($oldDBVars, $newDBVars, $getDBFileContents);
                    file_put_contents($catalogDbFile, $dbString);
                }

                // ------------------
                // Admin app.php
                $adminAppFile = ROOTPATH . 'admin/Config/App.php' . DIRECTORY_SEPARATOR;

                if (is_file($adminAppFile)) {
                    $getAdminAppFileContents = file_get_contents($adminAppFile);

                    $baseURL = base_url() . '/';
                    $adminURL = base_url('admin') . '/';

                    $baseURLString = str_replace(["http://ci4.localhost/", "http://ci4.localhost/admin/"], [BASE_URL, BASE_URL . 'admin/'], $getAdminAppFileContents);

                    file_put_contents($adminAppFile, $baseURLString);
                }

                // admin BD
                $adminDbFile = ROOTPATH . 'admin/Config/Database.php' . DIRECTORY_SEPARATOR;

                if (is_file($adminDbFile)) {
                    $getDBFileContents = file_get_contents($adminDbFile);

                    $oldDBVars = [
                        'hostname' => '127.0.0.1',
                        'username' => 'root',
                        'password' => '',
                        'database' => 'ci4',
                        'DBPrefix' => 'ci_',
                        'port'     => 3306,
                    ];

                    $newDBVars = [
                        'hostname' => $this->request->getPost('db_hostname'),
                        'username' => $this->request->getPost('db_username'),
                        'password' => $this->request->getPost('db_password'),
                        'database' => $this->request->getPost('db_database'),
                        'DBPrefix' => $this->request->getPost('db_prefix'),
                        'port'     => $this->request->getPost('db_port'),
                    ];

                    $dbString = str_replace($oldDBVars, $newDBVars, $getDBFileContents);
                    file_put_contents($adminDbFile, $dbString);
                }

            
                return redirect('/');
            }
        }

        $document->setTitle(lang('step_2.list.heading_title'));


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['db_driver'])) {
            $data['error_db_driver'] = $this->error['db_driver'];
        } else {
            $data['error_db_driver'] = '';
        }

        if (isset($this->error['db_hostname'])) {
            $data['error_db_hostname'] = $this->error['db_hostname'];
        } else {
            $data['error_db_hostname'] = '';
        }

        if (isset($this->error['db_username'])) {
            $data['error_db_username'] = $this->error['db_username'];
        } else {
            $data['error_db_username'] = '';
        }

        if (isset($this->error['db_database'])) {
            $data['error_db_database'] = $this->error['db_database'];
        } else {
            $data['error_db_database'] = '';
        }
        
        if (isset($this->error['db_port'])) {
            $data['error_db_port'] = $this->error['db_port'];
        } else {
            $data['error_db_port'] = '';
        }
        
        if (isset($this->error['db_prefix'])) {
            $data['error_db_prefix'] = $this->error['db_prefix'];
        } else {
            $data['error_db_prefix'] = '';
        }

        if (isset($this->error['username'])) {
            $data['error_username'] = $this->error['username'];
        } else {
            $data['error_username'] = '';
        }

        if (isset($this->error['password'])) {
            $data['error_password'] = $this->error['password'];
        } else {
            $data['error_password'] = '';
        }

        if (isset($this->error['email'])) {
            $data['error_email'] = $this->error['email'];
        } else {
            $data['error_email'] = '';
        }

        $data['action'] = route_to('install_step_2');

        $db_drivers = [
            'mysqli',
            'pdo',
            'pgsql'
        ];

        $data['drivers'] = [];

        foreach ($db_drivers as $db_driver) {
            if (extension_loaded($db_driver)) {
                $data['drivers'][] = [
                    'text'  => lang('step_2.list.text_' . $db_driver),
                    'value' => $db_driver
                ];
            }
        }

        if ($this->request->getPost('db_driver')) {
            $data['db_driver'] = $this->request->getPost('db_driver');
        } else {
            $data['db_driver'] = '';
        }

        if ($this->request->getPost('db_hostname')) {
            $data['db_hostname'] = $this->request->getPost('db_hostname');
        } else {
            $data['db_hostname'] = '127.0.0.1';
        }

        if ($this->request->getPost('db_username')) {
            $data['db_username'] = $this->request->getPost('db_username');
        } else {
            $data['db_username'] = 'root';
        }

        if ($this->request->getPost('db_password')) {
            $data['db_password'] = $this->request->getPost('db_password');
        } else {
            $data['db_password'] = '';
        }

        if ($this->request->getPost('db_database')) {
            $data['db_database'] = $this->request->getPost('db_database');
        } else {
            $data['db_database'] = '';
        }

        if ($this->request->getPost('db_port')) {
            $data['db_port'] = $this->request->getPost('db_port');
        } else {
            $data['db_port'] = 3306;
        }
        
        if ($this->request->getPost('db_prefix')) {
            $data['db_prefix'] = $this->request->getPost('db_prefix');
        } else {
            $data['db_prefix'] = 'ci_';
        }

        if ($this->request->getPost('username')) {
            $data['username'] = $this->request->getPost('username');
        } else {
            $data['username'] = 'admin';
        }

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        $data['config_name'] = 'CI4-App';

        $data['base']   = HTTP_SERVER;
        $data['back']   = base_url('index.php/step_1');
        $data['footer'] = sprintf(lang('footer.text_footer'), 'CI4-App');

        $data['csrf_token'] = csrf_token();
        $data['csrf_hash']  = csrf_hash();


        $document->setOutput('step_2', $data);
    }

    protected function validateForm()
    {
        if (!$this->request->getPost('db_hostname')) {
            $this->error['db_hostname'] = lang('step_2.error_db_hostname');
        }

        if (!$this->request->getPost('db_username')) {
            $this->error['db_username'] = lang('step_2.error_db_username');
        }

        if (!$this->request->getPost('db_database')) {
            $this->error['db_database'] = lang('step_2.error_db_database');
        }

        if (!$this->request->getPost('db_port')) {
            $this->error['db_port'] = lang('step_2.error_db_port');
        }

        if ($this->request->getPost('db_prefix') && preg_match('/[^a-z0-9_]/', $this->request->getPost('db_prefix'))) {
            $this->error['db_prefix'] = lang('step_2.error_db_prefix');
        }

        if (!$this->request->getPost('username')) {
            $this->error['username'] = lang('step_2.error_username');
        }

        if ((strlen($this->request->getPost('email')) > 96) || ! filter_var($this->request->getPost('email', FILTER_VALIDATE_EMAIL))) {
            $this->error['email'] = lang('step_2.error_email');
        }

        if (! $this->request->getPost('password')) {
            $this->error['password'] = lang('step_2.error_password');
        }

        if (!is_writable(ROOTPATH . 'catalog/Config/App.php')) {
            $this->error['warning'] = lang('step_2.error_config') . DIR_OPENCART . 'app.php!';
        }

        if (!is_writable(ROOTPATH . 'admin/Config/App.php')) {
            $this->error['warning'] = lang('step_2.error_config') . DIR_OPENCART . 'admin/config.php!';
        }

        return ! $this->error;
    }

    protected function checkDBConn(array $DBConfig = []): bool
    {
        $result = false;

        $custom = [
            'DSN'      => '',
            'hostname' => $DBConfig['db_hostname'],
            'username' => $DBConfig['db_username'],
            'password' => $DBConfig['db_password'],
            'database' => $DBConfig['db_database'],
            'DBDriver' => $DBConfig['db_driver'],
            'DBPrefix' => $DBConfig['db_prefix'],
            'pConnect' => false,
            'DBDebug'  => false,
            'cacheOn'  => false,
            'cacheDir' => '',
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => $DBConfig['db_port'],
            ];

        $db = \Config\Database::connect($custom);

        try {
            if ($db->persistentConnect()) {
                $result = true;
                $db->close();
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            $this->error['warning'] = $e->getCode() . ': ' . $e->getMessage();
            $result = false;
        }
        return $result;
    }
//  -------------------------------------------------
}
