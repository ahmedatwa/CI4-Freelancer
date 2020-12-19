<?php namespace Admin\Controllers\Tool;

class Log extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('tool/log.list.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('tool/log.list.heading_title'),
            'href' => base_url('index.php/tool/log?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['delete'] = base_url('index.php/tool/log/clear?user_token=' . $this->request->getVar('user_token'));

        // Getting the Error Logs
        helper('filesystem');

        $logsDirectory = WRITEPATH . 'logs/';
        $map = get_filenames($logsDirectory);
        $indexIgnore = ['index.html'];
        // Remove index.html
        $LogFiles = array_diff($map, $indexIgnore);
        
        $logs = [];

        foreach ($LogFiles as $file) {
            $FileDir = $logsDirectory . $file;
            //var_dump($FileDir);
            if (file_exists($FileDir)) {
                $logs[] = file_get_contents($FileDir, FILE_USE_INCLUDE_PATH, null);
            }
        }
        
        $data['log'] = '';
        foreach ($logs as $log) {
            $data['log'] = $log;
        }

        return $this->document->output('tool/log', $data);
    }

    public function clear()
    {
        $json = [];

        if (($this->request->getMethod() == 'post') && $this->validateDelete()) {
            helper('filesystem');

            $logs_dir = WRITEPATH . 'logs/';

            $log_files = get_filenames($logs_dir, true);
            // need to ignore index as (delete_files) doesn't work properly
            $ignore = [WRITEPATH . 'logs/index.html'];
            $logs = array_diff($log_files, $ignore);

            if (is_array($logs) && !empty($logs)) {
                foreach ($logs as $log) {
                    $file_ext = pathinfo($log, PATHINFO_EXTENSION);
                    if ($file_ext === 'log' && file_exists($log)) {
                        unlink($log);
                        $json['success'] = lang('user/user.text_success');
                        $json['redirect'] = base_url('index.php/tool/log?user_token=' . $this->request->getVar('user_token'));
                    } else {
                        $json['error_warning'] = lang('error_warning', 'tool/log.error_delete');
                    }
                }
            } else {
                $json['error_warning'] = lang('tool/log.not_found');
            }
        } else {
            $json['error_warning'] = $this->session->getFlashdata('error_warning');
        }
         
        return $this->response->setJSON($json);
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'tool/log')) {
            $this->session->setFlashdata('error_warning', lang('tool/log.error_permission'));
            return false;
        }
        return true;
    }


    //--------------------------------------------------------------------
}
