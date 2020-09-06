<?php namespace Admin\Controllers\Setting;

class Extension extends \Admin\Controllers\BaseController
{
    public function index()
    {

        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token')),
        ];

        if ($this->request->getVar('type')) {
			$data['type'] = $this->request->getVar('type');
		} else {
			$data['type'] = '';
		}

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->getFlashdata('warning')) {
            $data['warning'] = $this->session->getFlashdata('warning');
        } else {
            $data['warning'] = '';
        }

        $data['user_token'] = $this->request->getVar('user_token');

        $this->document->output('setting/extension', $data);
    }

    public function getList()
    {
        $json = [];
        // Data
        helper('filesystem');

        $extensionFiles = directory_map(APPPATH . 'Controllers/Extension/Extensions', 1);

        foreach ($extensionFiles as $file) {
            $basename = basename($file, '.php');
            
            if ($this->user->hasPermission('access', 'extension/extensions/' . strtolower($basename))) {

                $files = directory_map(APPPATH . 'Controllers/Extension/' . $basename);

                $json[] = [
                'code' => strtolower($basename),
                'text' => lang('extension/extensions/'. strtolower($basename) .'.list.heading_title') . ' (' . count($files) . ')',
                'href' => base_url('index.php/extension/extensions/' . strtolower($basename) . '?user_token=' . $this->session->get('user_token'))
              ];
            }
        }
        return $this->response->setJSON($json);
    }

        
    //--------------------------------------------------------------------
}
