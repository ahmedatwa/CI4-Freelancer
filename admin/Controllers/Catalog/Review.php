<?php namespace Admin\Controllers\Catalog;

class Review extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->reviews = new \Admin\Models\Catalog\Reviews();

        $this->document->setTitle(lang('catalog/review.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('catalog/review.list.text_add'));

        $this->reviews = new \Admin\Models\Catalog\Reviews();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->reviews->insert($this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/review?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('catalog/review.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('catalog/review.list.text_edit'));

        $this->reviews = new \Admin\Models\Catalog\Reviews();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->reviews->update($this->request->getVar('review_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/review?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('catalog/review.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $this->reviews = new \Admin\Models\Catalog\Reviews();
   
        $this->document->setTitle(lang('catalog/review.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $review_id) {
                $this->reviews->delete($review_id);
                $json['success'] = lang('catalog/review.text_success');
                $json['redirect'] = 'index.php/catalog/review?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('catalog/review.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/review.list.heading_title'),
            'href' => base_url('index.php/catalog/review?user_token=' . $this->session->get('user_token')),
        ];

        // Data
        $filter_data = [
            'start'    => 0,
            'order_by' => 'DESC',
            'sort_by'  => 'r.date_added',
            'limit'    => $this->registry->get('config_admin_limit')
        ];

        $data['reviews'] = [];
        $results = $this->reviews->getReviews($filter_data);

        foreach ($results as $result) {
            $data['reviews'][] = [
                'review_id' => $result['review_id'],
                'name'      => $result['name'],
                'author'    => $result['author'],
                'rating'    => $result['rating'],
                'status'    => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'      => base_url('index.php/catalog/review/edit?user_token=' . $this->session->get('user_token') . '&review_id=' . $result['review_id']),
                'delete'    => base_url('index.php/catalog/review/delete?user_token=' . $this->session->get('user_token') . '&review_id=' . $result['review_id']),
            ];
        }

        $data['add'] = base_url('index.php/catalog/review/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/catalog/review/delete?user_token=' . $this->session->get('user_token'));

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

        $data['user_token'] = $this->request->getGet('user_token');

        $this->document->output('catalog/review_list', $data);
    }

    protected function getForm()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/review.list.heading_title'),
            'href' => base_url('index.php/catalog/review/edit?user_token=' . $this->session->get('user_token')),
        ];

        $data['text_form'] = !$this->request->getGet('review_id') ? lang('catalog/review.list.text_add') : lang('catalog/review.list.text_edit');

        $data['cancel'] = base_url('index.php/catalog/review?user_token=' . $this->session->get('user_token'));

        $data['user_token'] = $this->session->get('user_token');

        if (!$this->request->getGet('review_id')) {
            $data['action'] = base_url('index.php/catalog/review/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/catalog/review/edit?user_token=' . $this->session->get('user_token') . '&review_id=' . $this->request->getGet('review_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getGet('review_id') && ($this->request->getMethod() != 'post')) {
            $review_info = $this->reviews->getReview($this->request->getGet('review_id'));
        }

        $projects_model = new \Admin\Models\Catalog\Projects();
        $data['projects'] = $projects_model->getProjects();

        if ($this->request->getPost('project_id')) {
            $data['project_id'] = $this->request->getPost('project_id');
        } elseif (!empty($review_info['project_id'])) {
            $data['project_id'] = $review_info['project_id'];
        } else {
            $data['project_id'] = '';
        }

        if ($this->request->getPost('author')) {
            $data['author'] = $this->request->getPost('author');
        } elseif (!empty($review_info)) {
            $data['author'] = $review_info['author'];
        } else {
            $data['author'] = '';
        }

        if ($this->request->getPost('text')) {
            $data['text'] = $this->request->getPost('text');
        } elseif (!empty($review_info)) {
            $data['text'] = $review_info['text'];
        } else {
            $data['text'] = '';
        }

        if ($this->request->getPost('rating')) {
            $data['rating'] = $this->request->getPost('rating');
        } elseif (!empty($review_info)) {
            $data['rating'] = $review_info['rating'];
        } else {
            $data['rating'] = '';
        }

        if ($this->request->getPost('date_added')) {
            $data['date_added'] = $this->request->getPost('date_added');
        } elseif (!empty($review_info)) {
            $data['date_added'] = DateShortFormat($review_info['date_added']);
        } else {
            $data['date_added'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($review_info)) {
            $data['status'] = $review_info['status'];
        } else {
            $data['status'] = '';
        }

        $this->document->output('catalog/review_form', $data);
    }

    public function autocomplete()
    {
        $json = [];

        if ($this->request->getGet('project_id')) {
            $reviews = new \Admin\Models\Catalog\Reviews();

            if ($this->request->getGet('project_id')) {
                $filter_name = html_entity_decode($this->request->getGet('project_id'), ENT_QUOTES, 'UTF-8');
            } else {
                $filter_name = null;
            }

            $filter_data = [
                'filter_name' => $filter_name,
                'start' => 0,
                'limit' => 5,
            ];

            $results = $reviews->getReviews($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'project_id' => $result['project_id'],
                    'name'       => $result['name']
                ];
            }
        }

        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        foreach ($this->request->getPost('job_description') as $language_id => $value) {
            if (! $this->validate([
                    "author" => [
                    'label' => 'Job Name',
                    'rules' => 'required|min_length[3]|max_length[64]'
                ],
                "project_id" => [
                    'label' => 'Job Description',
                    'rules' => 'required|min_length[3]'
                ],
                "text" => [
                    'label' => 'Job Description',
                    'rules' => 'required|min_length[1]'
                ],
                "rating" => [
                    'label' => 'Job Description',
                    'rules' => 'required|min_length[3]'
                ],
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('catalog/review.error_permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('catalog/review.error_permission'));
            return false;
        } 
         return true;
    }
        
    //--------------------------------------------------------------------
}
