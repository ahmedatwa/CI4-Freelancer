<?php 

namespace Catalog\Controllers\Information;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\InformationModel;

class Information extends BaseController
{
    // ---------------------------------
    //  Child function for failed routes
    // ---------------------------------
    public function view()
    {
        $this->index();
    }

    public function index(string $keyword = '')
    {
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang($this->locale .'.text_home'),
            'href' => base_url('/')
        ];

        $informationModel = new InformationModel();

        if ($keyword) {
            $queryID = $informationModel->findID($keyword);
        } 

        if ($this->request->getVar('fid')) {
            $information_id = $this->request->getVar('fid');
        } elseif ($queryID) {
            $information_id = $queryID;
        } else {
            $information_id = 0;
        }

        $information_info = $informationModel->getInformation($information_id);

        if ($information_info) {
            $this->template->setTitle($information_info['meta_title']);
            $this->template->setDescription($information_info['meta_description']);
            $this->template->setKeywords($information_info['meta_keyword']);

            $data['breadcrumbs'][] = [
                'text' => $information_info['title'],
                'href' => ($information_info['keyword']) ? route_to('information', $information_info['keyword']) : base_url('information/Information/view?fid=' . $information_id),
            ];

            $data['heading_title'] = $information_info['title'];

            $data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

            $data['langData'] = lang('information/information.list');

            $this->template->output('information/information', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    
    //--------------------------------------------------------------------
}