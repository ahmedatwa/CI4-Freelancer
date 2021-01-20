<?php namespace Catalog\Controllers\Information;

use \Catalog\Models\Catalog\Informations;

class Information extends \Catalog\Controllers\BaseController
{
    // --------------------
    //  Child function for failed routes
    public function view()
    {
        $this->index();
    }
    // -------------------
    public function index()
    {
        $informations = new Informations();

        $seo_url = service('seo_url');

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang($this->locale .'.text_home'),
            'href' => base_url('/')
        ];

        if ($this->request->getVar('fid')) {
            $information_id = $this->request->getVar('fid');
        } elseif ($this->request->getGet('information_id')) {
            $information_id = $this->request->getGet('information_id');
        } elseif ($this->request->uri->getSegment(2)) {
            $information_id = substr($this->request->uri->getSegment(2), 1);
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
                'href' => ($keyword) ? route_to('information/', $keyword) : base_url('information/Information?fid=' . $information_id),
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
