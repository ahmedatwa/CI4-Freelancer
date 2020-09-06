<?php namespace Admin\Controllers\Common;

class Filemanager extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $server = slash_item('baseURL');
        
        helper('filesystem');

        $images = array();

        // Make sure we have the correct directory
        if ($this->request->getGet('directory')) {
            $directory = DIR_IMAGE . 'catalog/' . $this->request->getGet('directory');
        } else {
            $directory = DIR_IMAGE . 'catalog/';
        }

        if (substr(str_replace('\\', '/', realpath($directory)), 0, strlen(DIR_IMAGE . 'catalog')) == str_replace('\\', '/', DIR_IMAGE . 'catalog')) {
            $images = directory_map($directory, 1);
        }

        $data['images'] = [];

        if ($images) {
            $source_dir = realpath($directory) ?: $directory;
            $source_dir = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            $folder_data = [];
            $file_data = [];
            foreach ($images as $image) {
                $basename = pathinfo($image, PATHINFO_BASENAME);
                $mime_type = mime_content_type($source_dir . $image);
               
                if (is_dir($source_dir . $image)) {
                    $url = '';

                    if ($this->request->getGet('target')) {
                        $url .= '&target=' . $this->request->getGet('target');
                    }
        
                    if ($this->request->getGet('thumb')) {
                        $url .= '&thumb=' . $this->request->getGet('thumb');
                    }
    
                    $folder_data[] = [
                    'thumb' => '',
                    'name'  => $basename,
                    'type'  => 'directory',
                    'path'  => str_replace('catalog/', '', substr(rtrim($source_dir . $image, '/'), strlen(DIR_IMAGE))),
                    'href'  => $server . 'index.php/common/filemanager?user_token=' . $this->session->get('user_token') . '&directory=' . urlencode(ltrim(str_replace('catalog/', '', str_replace(DIR_IMAGE, '', $directory . '/' . $basename)), '/')) . $url
                  ];
                }

                !empty($folder_data) ? ksort($folder_data) : false;

                if (is_file($source_dir . $image) && in_array($mime_type, array('image/gif', 'image/jpeg', 'image/png', 'image/bmp'))) {
                    $file_data[] = [
                    'thumb' => resizeImage(str_replace(DIR_IMAGE, '', $source_dir) . $basename, 100, 100),
                    'name'  => $basename,
                    'type'  => 'image',
                    'path'  => str_replace(DIR_IMAGE, '', $source_dir) . $basename,
                    'href'  => config('App')->httpCatalog .'images/' . substr($source_dir, strlen(DIR_IMAGE)) . $basename
                  ];
                }

                !empty($file_data) ? sort($file_data) : false;

                $data['images'] = array_merge($folder_data, $file_data);
            }
        }

        

        // Return the target ID for the file manager to set the value
        if ($this->request->getGet('target')) {
            $data['target'] = $this->request->getGet('target');
        } else {
            $data['target'] = '';
        }
        // Return the thumbnail for the file manager to show a thumbnail
        if ($this->request->getGet('thumb')) {
            $data['thumb'] = $this->request->getGet('thumb');
        } else {
            $data['thumb'] = '';
        }

        if ($this->request->getGet('directory')) {
            $data['directory'] = urlencode($this->request->getGet('directory'));
        } else {
            $data['directory'] = '';
        }

    
        // refresh
        $url = '';

        if ($this->request->getGet('directory')) {
            $url .= '&directory=' . urlencode($this->request->getGet('directory'));
        }

        if ($this->request->getGet('target')) {
            $url .= '&target=' . $this->request->getGet('target');
        }

        if ($this->request->getGet('thumb')) {
            $url .= '&thumb=' . $this->request->getGet('thumb');
        }

        $data['refresh'] = base_url('index.php/common/filemanager?user_token=' . $this->session->get('user_token') . $url);
        
        // Back
        if ($this->request->getGet('directory')) {
            $pos = strrpos($this->request->getGet('directory'), '/');
            if ($pos != false) {
                $url .= '&directory=' . urlencode(substr($this->request->getGet('directory'), 0, $pos));
            }
        }

        if ($this->request->getGet('target')) {
            $url .= '&target=' . $this->request->getGet('target');
        }

        if ($this->request->getGet('thumb')) {
            $url .= '&thumb=' . $this->request->getGet('thumb');
        }

        $data['back'] = base_url('index.php/common/filemanager?user_token=' . $this->session->get('user_token') . $url);


        $data['heading_title']  = lang('common/filemanager.heading_title');
        $data['entry_search']   = lang('common/filemanager.entry_search');
        $data['entry_folder']   = lang('common/filemanager.entry_folder');
        $data['button_upload']  = lang('common/filemanager.button_upload');
        $data['button_folder']  = lang('common/filemanager.button_folder');
        $data['button_delete']  = lang('common/filemanager.button_delete');
        $data['button_search']  = lang('common/filemanager.button_search');
        $data['button_back']    = lang('common/filemanager.button_back');
        $data['button_home']    = lang('common/filemanager.button_home');
        $data['button_refresh'] = lang('common/filemanager.button_refresh');
        $data['text_uploaded']  = lang('common/filemanager.text_uploaded');
        $data['text_directory'] = lang('common/filemanager.text_directory');
        $data['text_delete']    = lang('common/filemanager.text_delete');
        $data['text_confirm']   = lang('en.list.text_confirm');

        $data['home']   = base_url('index.php/common/filemanager?user_token=' . $this->session->get('user_token'));
        $data['search'] = base_url('index.php/common/filemanager?user_token=' .  $this->session->get('user_token') . '&directory=' . $directory);
        $data['folder'] = base_url('index.php/common/filemanager/folder?user_token=' .  $this->session->get('user_token') . '&directory=' . $directory);
        $data['delete'] = base_url('index.php/common/filemanager/delete?user_token=' .  $this->session->get('user_token'));

        $data['user_token'] = $this->session->get('user_token');

        echo view('common/filemanager', $data);
    }

    public function upload()
    {
        $json = array();

        // Check user has permission
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $json['error'] = lang('common/filemanager.error_permission');
        }

        // Make sure we have the correct directory
        if ($this->request->getGet('directory')) {
            $directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace(array('../', '..\\', '..'), '', $this->request->getGet('directory')), '/');
        } else {
            $directory = DIR_IMAGE . 'catalog';
        }

        // Check its a directory
        if (!is_dir($directory)) {
            $json['error'] = lang('common/filemanager.error_directory');
        }

        // Allowed file extension types
        $extensions = array('jpg','jpeg','gif','png', 'bmp');
        // Allowed file mime types
        $mimes = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif', 'image/bmp');

        $files = $this->request->getFiles();
        if ($files) {
            foreach ($files['file'] as $file) {
                $filename = $file->getName();
                $fileExtenstion = $file->getClientExtension();
                $fileType = $file->getClientMimeType();

                if (! $file->isValid()) {
                    throw new RuntimeException($file->getErrorString().'('.$file->getError().')');
                }

                if (!in_array($fileExtenstion, $extensions)) {
                    $json['error'] = lang('common/filemanager.error_filetype');
                }

                if (!in_array($fileType, $mimes)) {
                    $json['error'] = lang('common/filemanager.error_filetype');
                }

                if (!$json) {
                    if ($file->isValid() && ! $file->hasMoved()) {
                        $file->move($directory);
                        $json['success'] = lang('common/filemanager.text_uploaded');
                    }
                }
            }
        }


        return $this->response->setJSON($json);
    }

    public function folder()
    {
        $json = array();

        // Check user has permission
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $json['error'] = lang('common/filemanager.error_permission');
        }

        // Make sure we have the correct directory
        if ($this->request->getGet('directory')) {
            $directory = rtrim(str_replace(array('../', '..\\', '..'), '', $this->request->getGet('directory')), '/');
        } else {
            $directory = DIR_IMAGE . 'catalog';
        }

        // Check its a directory
        if (!is_dir($directory)) {
            $json['error'] = lang('common/filemanager.error_directory');
        }

        if (!$json) {
            // Sanitize the folder name
            $folder = str_replace(array('../', '..\\', '..'), '', basename(html_entity_decode($this->request->getPost('folder'), ENT_QUOTES, 'UTF-8')));

            // Validate the filename length
            if ((strlen($folder) < 3) || (strlen($folder) > 128)) {
                $json['error'] = lang('common/filemanager.error_folder');
            }
            // Check if directory already exists or not
            if (is_dir($directory . '/' . $folder)) {
                $json['error'] = lang('common/filemanager.error_exists');
            }
        }

        if (!$json) {
            mkdir($directory . '/' . $folder, 0777);
            chmod($directory . '/' . $folder, 0777);
            $json['success'] = lang('common/filemanager.text_directory');
        }

        return $this->response->setJSON($json);
    }

    public function delete()
    {
        $json = array();

        // Check user has permission
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $json['error'] = lang('common/filemanager.error_permission');
        }

        if ($this->request->getPost('path')) {
            $paths = $this->request->getPost('path');
        } else {
            $paths = [];
        }


        foreach ($paths as $path) {
            // Check path exsists
            if ($path == DIR_IMAGE . 'catalog') {
                 $json['error'] = lang('common/filemanager.error_delete');
                break;
            }
        }

        if (!$json) {
            // Loop through each path
            foreach ($paths as $path) {
                $path = rtrim(DIR_IMAGE . 'catalog/' . $path, '/');

                // If path is just a file delete it
                if (is_file($path)) {
                    unlink($path);
                }
                // If path is a directory
                if (is_dir($path)) {
                    helper('filesystem');
                    //beging deleting each file and sub folder
                    delete_files($path, true);
                    // Remove Dir
                    rmdir($path);
                }
            }
            $json['success'] = lang('common/filemanager.text_delete');
        }

        return $this->response->setJSON($json);
    }


    //--------------------------------------------------------------------
}
