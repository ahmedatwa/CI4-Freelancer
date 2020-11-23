<?php namespace Admin\Controllers\Catalog;

use \Admin\Models\Catalog\Categories;
use \Admin\Models\Localisation\Languages;

class Category extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $categoryModel = new Categories;

        $this->document->setTitle(lang('catalog/category.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('catalog/category.list.text_add'));

        $categoryModel = new Categories;

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $categoryModel->addCategory($this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/category?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('catalog/category.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('catalog/category.list.text_edit'));

        $categoryModel = new Categories;

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $categoryModel->editCategory($this->request->getVar('category_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/category?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('catalog/category.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $categoryModel = new Categories;
   
        $this->document->setTitle(lang('catalog/category.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $category_id) {
                $categoryModel->deleteCategory($category_id);
                $json['success'] = lang('catalog/category.text_success');
                $json['redirect'] = 'index.php/catalog/category?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('catalog/category.error_permission');
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
            'text' => lang('catalog/category.list.heading_title'),
            'href' => base_url('index.php/catalog/category?user_token=' . $this->session->get('user_token')),
        ];

        $categoryModel = new Categories;
        // Data
        $data['categories'] = [];

        $results = $categoryModel->getCategories();

        foreach ($results as $result) {
            $data['categories'][] = [
                'category_id' => $result['category_id'],
                'name'        => $categoryModel->getParentByCategoryId($result['category_id']) . $result['name'],
                'sort_order'  => $result['sort_order'],
                'status'      => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'        => base_url('index.php/catalog/category/edit?user_token=' . $this->session->get('user_token') . '&category_id=' . $result['category_id']),
                'delete'      => base_url('index.php/catalog/category/delete?user_token=' . $this->session->get('user_token') . '&category_id=' . $result['category_id']),
            ];
        }

        $data['add'] = base_url('index.php/catalog/category/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/catalog/category/delete?user_token=' . $this->session->get('user_token'));

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

        $this->document->output('catalog/category_list', $data);
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
            'text' => lang('catalog/category.list.heading_title'),
            'href' => base_url('index.php/catalog/category/edit?user_token=' . $this->session->get('user_token')),
        ];

        $data['text_form'] = !$this->request->getGet('category_id') ? lang('catalog/category.list.text_add') : lang('catalog/category.list.text_edit');

        $data['cancel'] = base_url('index.php/catalog/category?user_token=' . $this->session->get('user_token'));

        $data['user_token'] = $this->session->get('user_token');

        if (!$this->request->getGet('category_id')) {
            $data['action'] = base_url('index.php/catalog/category/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/catalog/category/edit?user_token=' . $this->session->get('user_token') . '&category_id=' . $this->request->getVar('category_id'));
        }

        if ($this->session->get('error_warning')) {
            $data['error_warning'] = $this->session->get('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $categoryModel = new Categories;

        if ($this->request->getGet('category_id') && ($this->request->getMethod() != 'post')) {
            $category_info = $categoryModel->getCategory($this->request->getGet('category_id'));
        }

        $languages = new Languages();
        $data['languages'] = $languages->where('status', 1)->findAll();

        if ($this->request->getPost('category_description')) {
            $data['category_description'] = $this->request->getPost('category_description');
        } elseif ($this->request->getVar('category_id')) {
            $data['category_description'] = $this->categories->getCategoryDescriptions($this->request->getVar('category_id'));
        } else {
            $data['category_description'] = [];
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($category_info)) {
            $data['sort_order'] = $category_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        $data['parents'] = $categoryModel->getCategoryParents();

        if ($this->request->getPost('parent_id')) {
            $data['parent_id'] = $this->request->getPost('parent_id');
        } elseif (!empty($category_info)) {
            $data['parent_id'] = $category_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }

        if ($this->request->getPost('icon')) {
            $data['icon'] = $this->request->getPost('icon');
        } elseif (!empty($category_info)) {
            $data['icon'] = $category_info['icon'];
        } else {
            $data['icon'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($category_info)) {
            $data['status'] = $category_info['status'];
        } else {
            $data['status'] = 1;
        }

        $this->document->output('catalog/category_form', $data);
    }

    public function autocomplete()
    {
        $json = [];

        if ($this->request->getVar('parent_id')) {

            $categoryModel = new Categories();

            if ($this->request->getVar('parent_id')) {
                $filter_name = $this->request->getVar('parent_id');
            } else {
                $filter_name = null;
            }

            $filter_data = [
                'filter_name' => $filter_name,
                'start'       => 0,
                'limit'       => 5,
            ];

            $results = $categoryModel->getCategories($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'parent_id' => $result['category_id'],
                    'name'      => $result['name']
                ];
            }
        }

        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        foreach ($this->request->getPost('category_description') as $language_id => $value) {
            if (! $this->validate([
                "category_description.{$language_id}.name" => [
                     'label' => 'Category Name', 'rules' => 'required|min_length[3]'
                ],
                "category_description.{$language_id}.meta_title" => [
                     'label' => 'Category Name', 'rules' => 'required|min_length[3]'
                ],
            ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }
    

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('catalog/category.error_permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('catalog/category.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
