<?php namespace Admin\Controllers\Design;

class Seo_url extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('design/seo_url.list.heading_title'));

        $this->seo_urls = new \Admin\Models\Design\seo_urls();

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('design/seo_url.list.heading_title'));

        $this->seo_urls = new \Admin\Models\Design\seo_urls();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->categories->addSeoUrl($this->request->getPost());
            return redirect()->to(base_url('index.php/design/seo_url?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('design/seo_url.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('design/seo_url.list.heading_title'));

        $this->seo_urls = new \Admin\Models\Design\seo_urls();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->categories->editSeoUrl($this->request->getVar('seo_url_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/design/seo_url?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('design/seo_url.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = array();

        $this->document->setTitle(lang('design/seo_url.list.heading_title'));
   
        $this->seo_urls = new \Admin\Models\Design\seo_urls();

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $seo_url_id) {
                $this->seo_urls->delete($seo_url_id);
                $json['success'] = lang('design/seo_url.text_success');
                $json['redirect'] = 'index.php/design/seo_url?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('design/seo_url.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('design/seo_url.list.heading_title'),
            'href' => base_url('index.php/design/seo_url?user_token=' . $this->session->get('user_token'))
        );

        $data['add'] = base_url('index.php/design/seo_url/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/design/seo_url/delete?user_token=' . $this->session->get('user_token'));

        $data['seo_urls'] = array();

        $results = $this->seo_urls->getSeoUrls();

        foreach ($results as $result) {
            $data['seo_urls'][] = array(
                'seo_url_id' => $result['seo_url_id'],
                'query'      => $result['query'],
                'keyword'    => $result['keyword'],
                'language'   => $result['language'],
                'edit'       => base_url('index.php/design/seo_url/edit?user_token=' . $this->session->get('user_token') . '&seo_url_id=' . $result['seo_url_id'])
            );
        }

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

        if (isset($this->request->getPost()['selected'])) {
            $data['selected'] = (array)$this->request->getPost()['selected'];
        } else {
            $data['selected'] = array();
        }

        
        $languages = new \Admin\Models\Localisation\Languages();
        
        $data['languages'] = $languages->findAll($this->registry->get('config_admin_limit'));
        
        $this->document->output('design/seo_url_list', $data);
    }

    protected function getForm()
    {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('design/seo_url.list.heading_title'),
            'href' => base_url('index.php/design/seo_url?user_token=' . $this->session->get('user_token'))
        );

        $data['text_form'] = !$this->request->getGet('seo_url_id') ? lang('catalog/information.list.text_add') : lang('catalog/information.list.text_edit');

        $data['cancel'] = base_url('index.php/design/seo_url?user_token=' . $this->session->get('user_token'));

        if (!$this->request->getGet('seo_url_id')) {
            $data['action'] = base_url('index.php/design/seo_url/add', 'user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/design/seo_url/edit?user_token=' . $this->session->data['user_token'] . '&seo_url_id=' . $this->request->getGet('seo_url_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $data['cancel'] = base_url('design/seo_url?user_token=' . $this->session->get('user_token'));

        if ($this->request->getGet('seo_url_id') && ($this->request->getMethod() != 'post')) {
            $seo_url_info = $this->seo_urls->find($this->request->getGet('seo_url_id'));
        }
        
        if ($this->request->getPost('query')) {
            $data['query'] = $this->request->getPost('query');
        } elseif (!empty($seo_url_info)) {
            $data['query'] = $seo_url_info['query'];
        } else {
            $data['query'] = '';
        }

        if ($this->request->getPost('keyword')) {
            $data['keyword'] = $this->request->getPost('keyword');
        } elseif (!empty($seo_url_info)) {
            $data['keyword'] = $seo_url_info['keyword'];
        } else {
            $data['keyword'] = '';
        }
                
        // $this->load->model('setting/store');

        // $data['stores'] = array();
        
        // $data['stores'][] = array(
        // 	'store_id' => 0,
        // 	'name'     => lang('design/seo_url.list.text_default')
        // );
        
        // $stores = $this->model_setting_store->getStores();

        // foreach ($stores as $store) {
        // 	$data['stores'][] = array(
        // 		'store_id' => $store['store_id'],
        // 		'name'     => $store['name']
        // 	);
        // }
                
        // if (isset($this->request->post['store_id'])) {
        // 	$data['store_id'] = $this->request->post['store_id'];
        // } elseif (!empty($seo_url_info)) {
        // 	$data['store_id'] = $seo_url_info['store_id'];
        // } else {
        // 	$data['store_id'] = '';
        // }
                
        $languages = new \Admin\Models\Localisation\Languages();
        
        $data['languages'] = $languages->findAll($this->registry->get('config_admin_limit'));

        if ($this->request->getPost('language_id')) {
            $data['language_id'] = $this->request->getPost('language_id');
        } elseif (!empty($seo_url_info)) {
            $data['language_id'] = $seo_url_info['language_id'];
        } else {
            $data['language_id'] = '';
        }


        $this->document->output('design/seo_url_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'design/seo_url')) {
            $this->error['warning'] = lang('design/seo_url.list.error_permission');
        }

        if (!$this->request->post['query']) {
            $this->error['query'] = lang('design/seo_url.list.error_query');
        }
        
        $seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($this->request->post['keyword']);

        foreach ($seo_urls as $seo_url) {
            if ($seo_url['store_id'] == $this->request->post['store_id'] && $seo_url['query'] != $this->request->post['query']) {
                $this->error['keyword'] = lang('design/seo_url.list.error_exists');
                
                break;
            }
        }
        
        if (!$this->request->post['keyword']) {
            $this->error['keyword'] = lang('design/seo_url.list.error_keyword');
        }
        
        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'design/seo_url')) {
            $this->error['warning'] = lang('design/seo_url.list.error_permission');
        }

        return !$this->error;
    }
}
