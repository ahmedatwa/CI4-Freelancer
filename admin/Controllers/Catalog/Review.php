<?php namespace Admin\Controllers\Catalog;

use \Admin\Models\Catalog\Reviews;
use \Admin\Models\Catalog\Projects;

class Review extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $reviewModel = new Reviews();

        $this->document->setTitle(lang('catalog/review.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('catalog/review.list.text_add'));

        $reviewModel = new Reviews();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $reviewModel->insert($this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/review?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('catalog/review.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('catalog/review.list.text_edit'));

        $reviewModel = new Reviews();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $reviewModel->update($this->request->getVar('review_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/review?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('catalog/review.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $reviewModel = new Reviews();
   
        $this->document->setTitle(lang('catalog/review.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $review_id) {
                $reviewModel->delete($review_id);
                $json['success'] = lang('catalog/review.text_success');
                $json['redirect'] = 'index.php/catalog/review?user_token=' . $this->request->getVar('user_token');
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
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/review.list.heading_title'),
            'href' => base_url('index.php/catalog/review?user_token=' . $this->request->getVar('user_token')),
        ];

        $reviewModel = new Reviews();

        $data['reviews'] = [];
        // Data
        $filter_data = [
            'start'    => 0,
            'order_by' => 'DESC',
            'sort_by'  => 'r.date_added',
            'limit'    => $this->registry->get('config_admin_limit')
        ];

        $results = $reviewModel->getReviews($filter_data);

        foreach ($results as $result) {
            $data['reviews'][] = [
                'review_id' => $result['review_id'],
                'name'      => $result['name'],
                'author'    => $result['author'],
                'rating'    => $result['rating'],
                'status'    => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'      => base_url('index.php/catalog/review/edit?user_token=' . $this->request->getVar('user_token') . '&review_id=' . $result['review_id']),
                'delete'    => base_url('index.php/catalog/review/delete?user_token=' . $this->request->getVar('user_token') . '&review_id=' . $result['review_id']),
            ];
        }

        $data['add'] = base_url('index.php/catalog/review/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/catalog/review/delete?user_token=' . $this->request->getVar('user_token'));

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
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/review.list.heading_title'),
            'href' => base_url('index.php/catalog/review/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getGet('review_id') ? lang('catalog/review.list.text_add') : lang('catalog/review.list.text_edit');

        $data['cancel'] = base_url('index.php/catalog/review?user_token=' . $this->request->getVar('user_token'));

        $data['user_token'] = $this->request->getVar('user_token');

        if (!$this->request->getVar('review_id')) {
            $data['action'] = base_url('index.php/catalog/review/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/catalog/review/edit?user_token=' . $this->request->getVar('user_token') . '&review_id=' . $this->request->getVar('review_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }   

        $reviewModel = new Reviews();

        if ($this->request->getVar('review_id') && ($this->request->getMethod() != 'post')) {
            $review_info = $reviewModel->getReview($this->request->getVar('review_id'));
        }

        $projectModel = new Projects();
        $data['projects'] = $projectModel->getProjects();

        if (!empty($review_info['project_id'])) {
            $data['project_id'] = $review_info['project_id'];
        } else {
            $data['project_id'] = '';
        }

        if (!empty($review_info)) {
            $data['author'] = $review_info['author'];
        } else {
            $data['author'] = '';
        }

        if (!empty($review_info)) {
            $data['comment'] = $review_info['comment'];
        } else {
            $data['comment'] = '';
        }

        if (!empty($review_info)) {
            $data['rating'] = $review_info['rating'];
        } else {
            $data['rating'] = '';
        }

        if (!empty($review_info)) {
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
            $reviewModel = new Reviews();

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

            $results = $reviewModel->getReviews($filter_data);

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
        if (! $this->user->hasPermission('modify', 'catalog/review')) {
            $this->session->setFlashdata('error_warning', lang('catalog/review.error_permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'catalog/review')) {
            $this->session->setFlashdata('error_warning', lang('catalog/review.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
