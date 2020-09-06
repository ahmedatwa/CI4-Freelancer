<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends MY_Controller
{

    public function index()
    {
        $this->lang->load('common/search');

        if (!empty($this->input->get('search'))) {
            $search = $this->input->get('search');
        } else {
            $search = '';
        }

        if ($this->input->get('filter')) {
            $filter = explode(',', $this->input->get('filter'));
        } else {
            $filter = array();
        }
        
        if ($this->input->get('filter_price')) {
            $filter_price = explode(',', $this->input->get('filter_price'));
        } else {
            $filter_price = array();
        }

        if ($this->input->get('sort_by')) {
            $sort_by = $this->input->get('sort_by');
        } else {
            $sort_by = 's.price';
        }

        if ($this->input->get('order_by')) {
            $order_by = $this->input->get('order_by');
        } else {
            $order_by = 'ASC';
        }

        if ($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        } else {
            $limit = 20;
        }

        if ($this->input->get('page')) {
            $page = $this->input->get('page');
        } else {
            $page = 1;
        }

        $filter_data = array(
            'search'       => $search,
            'filter'       => $filter,
            'filter_price' => $filter_price,
            'sort_by'      => $sort_by,
            'order_by'     => $order_by,
            'limit'        => $limit,
            'start'        => ($page - 1) * $limit,
        );

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->lang->line('text_home'),
            'href' => base_url(),
        );
        $data['breadcrumbs'][] = array(
            'text' => $this->lang->line('text_search'),
            'href' => base_url('common/search?search='.$this->input->get('search')),
        );

        if ($order_by == 'DESC') {
            $order_by = '&order_by=ASC';
        } else {
            $order_by = '&order_by=DESC';
        }

        $url = '';

        if ($this->input->get('limit')) {
            $url .= '&limit=' . $this->input->get('limit');
        }

        if ($this->input->get('sort_by')) {
            $url .= '&sort_by=' . $this->input->get('sort_by');
        }

        if ($this->input->get('order_by')) {
            $url .= '&order_by=' . $this->input->get('order_by');
        }


        // Category Services
        $this->load->model('service/services');
        $data['services'] = array();
        $results = $this->services->get_services($filter_data);
        $total_services = $this->services->get_total_services();
        
        foreach ($results as $result) {
            if ($result['image']) {
                $image = thumb($result['image'], 361, 230);
            } else {
                $image = img_url('p4.jpg');
            }
        
            $data['services'][]= array(
                'service_id'  => $result['service_id'],
                'name'        => $result['service'],
                'seller'      => $result['seller'],
                'image'       => $image,
                'category'    => $this->services->get_category_by_serviceId($result['service_id']),
                'seller_img'  => img_url('auth.jpg'),
                'rating'      => $result['rating'],
                'price'       => currency_format($result['price']),
                'description' => substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 200),
                'href'        => base_url('service/service?service_id='.$result['service_id'] . $url),
             );
        }


        $data['sorts'] = array();

        $data['sorts'][] = array(
            'text'  => $this->lang->line('text_price_asc'),
            'value' => 's.price-ASC',
            'href'  => base_url('service/category?category_id=' . $this->input->get('category_id') . '&sort_by=s.price&order_by=ASC' . $url)
        );

        $data['sorts'][] = array(
            'text'  => $this->lang->line('text_price_desc'),
            'value' => 's.price-DESC',
            'href'  => base_url('service/category?category_id=' . $this->input->get('category_id') . '&sort_by=s.price&order_by=DESC' .$url)
        );

        $data['sort_date_added'] = base_url('service/category?category_id=' . $this->input->get('category_id') . $url. '&sort_by=s.date_added'. $order_by);


        $url = '';

        if ($this->input->get('sort_by')) {
            $url .= '&sort_by=' . $this->input->get('sort_by');
        }

        if ($this->input->get('order_by')) {
            $url .= '&order_by=' . $this->input->get('order_by');
        }

        $data['limits'] = array();

        $limits = array_unique(array(20, 25, 50, 75, 100));

        sort($limits);

        foreach ($limits as $value) {
            $data['limits'][] = array(
                'text'  => sprintf($this->lang->line('text_per_page'), $value),
                'value' => $value,
                'href'  => base_url('service/category?category_id=' . $this->input->get('category_id') . $url . '&limit=' . $value)
            );
        }


        $url = '';


        if ($this->input->get('limit')) {
            $url .= '&limit=' . $this->input->get('limit');
        }

        if ($this->input->get('sort_by')) {
            $url .= '&sort_by=' . $this->input->get('sort_by');
        }

        if ($this->input->get('order_by')) {
            $url .= '&order_by=' . $this->input->get('order_by');
        }

        $data['heading_title']    = $this->lang->line('heading_title');
        $data['text_price']       = $this->lang->line('text_price');
        $data['text_sort']        = $this->lang->line('text_sort');
        $data['text_default']     = $this->lang->line('text_default');
        $data['text_name_asc']    = $this->lang->line('text_name_asc');
        $data['text_name_desc']   = $this->lang->line('text_name_desc');
        $data['text_price_asc']   = $this->lang->line('text_price_asc');
        $data['text_price_desc']  = $this->lang->line('text_price_desc');
        $data['text_rating_asc']  = $this->lang->line('text_rating_asc');
        $data['text_rating_desc'] = $this->lang->line('text_rating_desc');
        $data['text_limit']       = $this->lang->line('text_limit');
        $data['text_grid']        = $this->lang->line('text_grid');
        $data['text_list']        = $this->lang->line('text_list');
        $data['text_new']         = $this->lang->line('text_new');
        $data['text_recent']      = $this->lang->line('text_recent');
        $data['text_featured']    = $this->lang->line('text_featured');
        $data['text_search']      = $this->lang->line('text_search');
        $data['text_categories']  = $this->lang->line('text_categories');
        $data['text_empty']       = $this->lang->line('text_empty');

        $data['button_cart']      = $this->lang->line('button_cart');
        $data['button_list']      = $this->lang->line('button_list');
        $data['button_search']    = $this->lang->line('button_search');
        $data['button_grid']      = $this->lang->line('button_grid');
        $data['button_more_info'] = $this->lang->line('button_more_info');


        $this->load->model('service/categories');
        $categories = $this->categories->get_main_categories();
        $data['categories'] = array();
        foreach ($categories as $category) {
            $data['categories'][] = array(
                'name'  => $category['name'],
                'id'    => '?category_id=' . $category['category_id'],
                'total' => $this->categories->get_category_total($category['category_id']),
                'href'  => base_url('index.php/service/category?category_id=' . $category['category_id']),
            );
        }

        $url = '';


        if ($this->input->get('limit')) {
            $url .= '&limit=' . $this->input->get('limit');
        }
  
        if ($this->input->get('sort_by')) {
            $url .= '&sort_by=' . $this->input->get('sort_by');
        }
  
        if ($this->input->get('order_by')) {
            $url .= '&order_by=' . $this->input->get('order_by');
        }
  
        $config['base_url'] = base_url('service/category?search' . $this->input->get('serach'));
        $config['total_rows'] = $total_services;
        $config['per_page'] = $limit;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['text_pagination'] = sprintf($this->lang->line('text_pagination'), ($total_services) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($total_services - $limit)) ? $total_services : ((($page - 1) * $limit) + $limit), $total_services, ceil($total_services / $limit));

        
        $data['filter']   = $filter;
        $data['search']   = $search;
        $data['sort_by']  = $sort_by;
        $data['order_by'] = $order_by;
        $data['limit']    = $limit;
        $data['page']     = $page;

        
        $data['content_bottom'] = Modules::run('content_bottom');


        $this->theme->render('common/search', $data);
    }
}
