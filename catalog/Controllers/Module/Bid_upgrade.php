<?php

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\ProjectModel;

class Bid_upgrade extends BaseController
{
    public function index()
    {
        if ($this->registry->get('module_bid_upgrade_setting')) {
            $data['module_setting'] = json_decode($this->registry->get('module_bid_upgrade_setting'));
        }
        
        $data['config_currency'] = $this->registry->get('config_currency');

        $data['langData'] = lang('module/bid_upgrade.list');

        return view('module/bid_upgrade', $data);
    }

    // --------------------------------------------
}
