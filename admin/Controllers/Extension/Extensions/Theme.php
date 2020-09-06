<?php namespace Admin\Controllers\Extension\Extensions;

class Theme extends \Admin\Controllers\BaseController
{
	public function index() {

		$extension_model = new \Admin\Models\Setting\Extensions();

		$this->getList();
	}

	public function install() {

		$extension_model = new \Admin\Models\Setting\Extensions();

		if ($this->validateForm()) {
			$extension_model->install('theme', $this->request->getVar('extension'));

            $usergroup_model = new \Admin\Models\User\Users_group();

            $usergroup_model->addPermission($this->user->getGroupId(), 'access', 'extension/theme/' . $this->request->getVar('extension'));
            $usergroup_model->addPermission($this->user->getGroupId(), 'modify', 'extension/theme/' . $this->request->getVar('extension'));

            $this->session->setFlashdata('success', lang('setting/extension.list.text_success'));
		}

		$this->getList();
	}

	public function uninstall() {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

		$extension_model = new \Admin\Models\Setting\Extensions();

		if ($this->validateForm()) {
			$extension_model->uninstall('theme', $this->request->getVar('extension'));

            $this->session->setFlashdata('success', lang('setting/extension.list.text_success'));
		}
		
		$this->getList();
	}

	protected function getList() {

		$extension_model = new \Admin\Models\Setting\Extensions();

        if ($this->session->getFlashdata('warning')) {
            $data['error_warning'] = $this->session->getFlashdata('warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $installedExtensions = $extension_model->getInstalled('theme');

		foreach ($installedExtensions as $key => $value) {
			if (!is_file(APPPATH . 'Controllers/extension/Theme/' . $value . '.php') && !is_file(APPPATH . 'Controller/theme/' . $value . '.php')) {
				$extension_model->uninstall('theme', $value);

				unset($installedExtensions[$key]);
			}
		}

        $data['extensions'] = array();
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Controllers/Extension/Theme', 1);

		$data['extensions'] = array();
		
		if ($files) {
			foreach ($files as $file) {
				$basename = basename($file, '.php');

				$data['extensions'][] = array(
					'name'      => lang('extension/theme/' . strtolower($basename) . '.list.heading_title'),
					'install'   => base_url('index.php/extension/extensions/theme/install?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
					'uninstall' => base_url('index.php/extension/extensions/theme/uninstall?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
					'installed' => in_array(strtolower($basename), $installedExtensions),
                    'edit'      => base_url('index.php/extension/theme/' . strtolower($basename) .'?user_token=' . $this->session->get('user_token')),
				);
			}
		}

		$this->document->output('extension/extensions/theme', $data);
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/extensions/theme')) {
            $this->session->setFlashdata('warning', lang('extension/extensions/theme.error_permission'));
            return false;
		} else {
			return true;
		}
	}

	// -----------------------------------------------------------
}