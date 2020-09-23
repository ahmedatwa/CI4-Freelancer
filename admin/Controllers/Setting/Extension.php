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
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token')),
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

        helper('filesystem');

        $data['categories'] = [];

        $files = directory_map(APPPATH . 'Controllers/Extension', 1);

        foreach ($files as $file) {
            $basename = basename($file, '.php');

            if ($this->user->hasPermission('access', 'extension/' . strtolower($basename))) {
                $children = directory_map(APPPATH . 'Extensions/Controllers/' . ucfirst($basename), 1);

                $data['categories'][] = [
                'code' => strtolower($basename),
                'text' => lang('extension/'. strtolower($basename) .'.list.heading_title') . ' (' . count($children) . ')',
                'href' => base_url('index.php/extension/' . strtolower($basename) . '?user_token=' . $this->request->getVar('user_token'))
              ];
            }
        }

        $this->document->output('setting/extension', $data);
    }
        
    //--------------------------------------------------------------------
}
