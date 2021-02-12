<?php

namespace Install\Controllers;

use CodeIgniter\Controller;
use Install\Libraries\Document;

class Step_1 extends Controller
{
    protected $error = [];
    
    public function index()
    {

        if (($this->request->getMethod(true) == 'POST') && $this->validateForm()) {
            return redirect()->to(base_url('index.php/step_2'));
        }

        $document = new Document();

        $document->setTitle(lang('step_1.list.heading_title'));
        
        $data['base'] = HTTP_SERVER;

        $data['config_name'] = 'CI-App';

        $data['php_version']        = phpversion();
        $data['register_globals']   = ini_get('register_globals');
        $data['magic_quotes_gpc']   = ini_get('magic_quotes_gpc');
        $data['file_uploads']       = ini_get('file_uploads');
        $data['session_auto_start'] = ini_get('session_auto_start');

        $db = [
            'mysqli',
            'pgsql',
            'pdo'
        ];

        if (!array_filter($db, 'extension_loaded')) {
            $data['db'] = false;
        } else {
            $data['db'] = true;
        }

        $data['gd']       = extension_loaded('gd');
        $data['curl']     = extension_loaded('curl');
        $data['openssl']  = function_exists('openssl_encrypt');
        $data['zlib']     = extension_loaded('zlib');
        $data['zip']      = extension_loaded('zip');
        $data['iconv']    = function_exists('iconv');
        $data['mbstring'] = extension_loaded('mbstring');
        $data['intl']     = extension_loaded('intl');

        $data['catalog_config'] = ROOTPATH . 'catalog/config/app.php';
        $data['admin_config']   = ROOTPATH . 'admin/config/app.php';
        $data['image']          = FCPATH . '../images';
        $data['image_cache']    = FCPATH . '../images/cache';
        $data['cache']          = ROOTPATH . 'storage/cache';
        $data['logs']           = ROOTPATH . 'storage/logs';
        $data['download']       = ROOTPATH . 'storage/download';
        $data['upload']         = ROOTPATH . 'storage/uploads';

        $data['action'] = base_url('index.php/step_1');
        $data['footer'] = sprintf(lang('footer.text_footer'), 'CI4-App');

        $data['csrf_token'] = csrf_token();
        $data['csrf_hash'] = csrf_hash();

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // catalog config
		if (! is_writable(ROOTPATH . 'catalog/Config/config.php')) {
			$data['error_catalog_config'] = lang('step_1.error_unwritable');
		} else {
			$data['error_catalog_config'] = '';
		}

		// admin configs
		if (!is_writable(ROOTPATH . 'admin/Config/config.php')) {
			$data['error_admin_config'] = lang('step_1.error_unwritable');
		} else {
			$data['error_admin_config'] = '';
		}
 
        $document->setOutput('step_1', $data);
    }

    protected function validateForm()
    {
        if (phpversion() < '7.3') {
            $this->error['warning'] = lang('step_1.error_version');
        }

        if (!ini_get('file_uploads')) {
            $this->error['warning'] = lang('step_1.error_file_upload');
        }

        if (ini_get('session.auto_start')) {
            $this->error['warning'] = lang('step_1.error_session');
        }

        $db = [
            'mysqli',
            'pdo',
            'pgsql'
        ];

        if (!array_filter($db, 'extension_loaded')) {
            $this->error['warning'] = lang('step_1.error_db');
        }

        if (!extension_loaded('gd')) {
            $this->error['warning'] = lang('step_1.error_gd');
        }

        if (!extension_loaded('curl')) {
            $this->error['warning'] = lang('step_1.error_curl');
        }

        if (!function_exists('openssl_encrypt')) {
            $this->error['warning'] = lang('step_1.error_openssl');
        }

        if (!extension_loaded('zlib')) {
            $this->error['warning'] = lang('step_1.error_zlib');
        }

        if (!extension_loaded('zip')) {
            $this->error['warning'] = lang('step_1.error_zip');
        }

        if (!extension_loaded('mbstring')) {
            $this->error['warning'] = lang('step_1.error_mbstring');
        }

        if (!extension_loaded('intl')) {
            $this->error['warning'] = lang('step_1.error_intl');
        }

        if (! file_exists(ROOTPATH . 'catalog/config/App.php')) {
            $this->error['warning'] = lang('step_1.error_catalog_exist');
        } elseif (!is_writable(ROOTPATH . 'catalog/config/App.php')) {
            $this->error['warning'] = lang('step_1.error_catalog_writable');
        }

        if (! file_exists(ROOTPATH . 'admin/config/App.php')) {
            $this->error['warning'] = lang('step_1.error_admin_exist');
        } elseif (!is_writable(ROOTPATH . 'admin/config/App.php')) {
            $this->error['warning'] = lang('step_1.error_admin_writable');
        }

        if (!is_writable(ROOTPATH . 'public_html/images')) {
            $this->error['warning'] = lang('step_1.error_image');
        }

        if (!is_writable(ROOTPATH . 'public_html/images/cache')) {
            $this->error['warning'] = lang('step_1.error_image_cache');
        }

        if (!is_writable(ROOTPATH . 'storage/cache')) {
            $this->error['warning'] = lang('step_1.error_cache');
        }

        if (!is_writable(ROOTPATH . 'storage/logs')) {
            $this->error['warning'] = lang('step_1.error_log');
        }

        if (!is_writable(ROOTPATH . 'storage/download')) {
            $this->error['warning'] = lang('step_1.error_download');
        }

        if (!is_writable(ROOTPATH . 'storage/uploads')) {
            $this->error['warning'] = lang('step_1.error_upload');
        }

        return !$this->error;
    }
}
