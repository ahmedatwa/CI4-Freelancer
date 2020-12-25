<?php namespace Admin\Controllers\Common;

use \Admin\Models\User\UserModel;
use \Admin\Models\Catalog\ProjectModel;

class Header extends \Admin\Controllers\BaseController
{
    public function index()
    {

        $data['title']       = $this->document->getTitle();
        $data['description'] = $this->document->getDescription();
        $data['keywords']    = $this->document->getKeywords();
        $data['links']       = $this->document->getLinks();
        $data['styles']      = $this->document->getStyles();

        $data['admin_panel_title'] = lang('common/header.admin_panel_title');
        $data['text_logout']       = lang('common/header.text_logout');
        $data['text_profile']      = lang('common/header.text_profile');
        $data['text_activity']     = lang('common/header.text_activity');
        $data['text_site']         = $this->registry->get('config_name');
        $data['text_setting']      = lang('common/header.text_setting');
        $data['lang']              = lang('en.code');
        $data['direction']         = lang('en.direction');

        $data['base']      = slash_item('baseURL');
        $data['home']      = ($this->request->getVar('user_token')) ? base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')) : '#';
        $data['profile']   = base_url('index.php/user/user/edit?user_token=' . $this->request->getVar('user_token') . '&user_id='. $this->user->getUserID());
        $data['logout']    = base_url('index.php/common/logout');
        $data['activity']  = base_url('index.php/report/activity_log?user_token=' . $this->request->getVar('user_token'));
        $data['setting']   = base_url('index.php/setting/setting?user_token=' . $this->request->getVar('user_token'));
        $data['site']      = slash_item('httpCatalog');

        $data['logged'] = $this->user->isLogged();
        
        $userModel = new UserModel();

        if ($this->user->isLogged() && $this->user->getUserId()) {
            $user_info = $userModel->find($this->user->getUserId());

            if ($user_info) {
                $data['firstname']     = $user_info['firstname'];
                $data['lastname']      = $user_info['lastname'];
                $data['username']      = $user_info['username'];
                $data['user_group_id'] = $user_info['user_group_id'];
    
                if (is_file(DIR_IMAGE . $user_info['image'])) {
                    $data['image'] = resizeImage($user_info['image'], 45, 45);
                } else {
                    $data['image'] = resizeImage('profile.png', 45, 45);
                }
            } else {
                $data['firstname']     = '';
                $data['lastname']      = '';
                $data['user_group_id'] = '';
                $data['image']         = '';
            }
        }

        $projectModel = new ProjectModel();

        $data['notifications'] = [];
        
        $filter_data = [
            'filter_date_added' => date("Y-m-d"),
            'sort_by'           => 'pd.name',
            'order_by'          => 'DESC',
            'start'             => 0,
            'limit'             => 5,
        ];

        $data['notifications_total'] = $projectModel->getTotalProjects($filter_data);
        $results = $projectModel->getProjects($filter_data);
        foreach ($results as $result) {
            $data['notifications'][] = [
                'name' => substr($result['name'], 0, 30) . '...', 
                'href' => base_url('index.php/catalog/project/edit?user_token=' . $this->request->getVar('user_token') . '&project_id=' . $result['project_id']),
            ];
        }

        return view('common/header', $data);
    }

    //--------------------------------------------------------------------
}
