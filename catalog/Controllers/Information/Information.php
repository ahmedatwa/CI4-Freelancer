<?php namespace Catalog\Controllers\Information;

use \Catalog\Models\Design\Seo_urls;
use \Catalog\Models\Catalog\Informations;

class Information extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $informations = new Informations();

        $seo_urls = new Seo_urls();

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang($this->locale .'.text_home'),
            'href' => base_url('/')
        ];

        if ($this->request->getGet('information_id')) {
            $information_id = (int) $this->request->getGet('information_id');
        } else {
            $information_id = 0;
        }

        $information_info = $informations->getInformation($information_id);

        if ($information_info) {
            $this->template->setTitle($information_info['meta_title']);
            $this->template->setDescription($information_info['meta_description']);
            $this->template->setKeywords($information_info['meta_keyword']);

            $data['breadcrumbs'][] = [
                'text' => $information_info['title'],
                'href' => base_url('information/' . $seo_urls->getKeywordByQuery('information_id=' . $information_id)),
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
