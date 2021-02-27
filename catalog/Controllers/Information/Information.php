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
        $seo_url = service('seo_url');

        if ($keyword) {
            $query_id = substr($seo_url->getQueryByKeyword($keyword), -1);
        } 

        $informations = new InformationModel();

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang($this->locale .'.text_home'),
            'href' => base_url('/')
        ];

        if ($this->request->getVar('fid')) {
            $information_id = $this->request->getVar('fid');
        } elseif ($query_id) {
            $information_id = $query_id;
        } elseif ($this->request->getGet('information_id')) {
            $information_id = $this->request->getGet('information_id');
        } else {
            $information_id = 0;
        }

        $information_info = $informations->getInformation($information_id);

        if ($information_info) {
            $this->template->setTitle($information_info['meta_title']);
            $this->template->setDescription($information_info['meta_description']);
            $this->template->setKeywords($information_info['meta_keyword']);

            $keyword = $seo_url->getKeywordByQuery('information_id=' . $information_id);

            $data['breadcrumbs'][] = [
                'text' => $information_info['title'],
                'href' => ($keyword) ? route_to('information', $keyword) : base_url('information/Information/view?fid=' . $information_id),
            ];

            $data['heading_title'] = $information_info['title'];

            $data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

            $this->template->output('information/information', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    
    //--------------------------------------------------------------------
}