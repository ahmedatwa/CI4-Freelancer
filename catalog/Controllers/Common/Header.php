<?php namespace Catalog\Controllers\Common;

class Header extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['title']       = $this->template->getTitle();
        $data['description'] = $this->template->getDescription();
        $data['keywords']    = $this->template->getKeywords();
        $data['links']       = $this->template->getLinks();
        $data['styles']      = $this->template->getStyles();

        $data['base'] = slash_item('baseURL');

        $uri = new \CodeIgniter\HTTP\URI((string)current_url(true));

        $data['route'] = $uri->getSegment(1);


        return view('common/header', $data);
    }


    //--------------------------------------------------------------------
}
