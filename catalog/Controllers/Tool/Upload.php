<?php namespace Catalog\Controllers\Tool;

use \Catalog\Models\Tool\UploadModel;
use \Catalog\Models\Catalog\ProjectModel;

class Upload extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $json = [];

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } else {
            $project_id = 0;
        }

        if (! $this->customer->isLogged()) {
            $json['error'] = 'Please login';
        }


        if ($file = $this->request->getFile('file')) {

            // Validate the filename length
            if ((strlen($file->getName()) < 3) || (strlen($file->getName()) > 64)) {
                $json['error'] = lang('tool/upload.error_filename');
            }

            $file_ext_allowed = preg_replace('~\r?\n~', "\n", $this->registry->get('config_file_ext_allowed'));

            $filetypes = explode("\n", $file_ext_allowed);

            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }
            
            if (!in_array($file->getClientExtension(), $allowed)) {
                $json['error'] = lang('tool/upload.error_filetype');
            }

            // Allowed file mime types
            $file_mime_allowed = preg_replace('~\r?\n~', "\n", $this->registry->get('config_file_mime_allowed'));

            $filetypes = explode("\n", $file_mime_allowed);

            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }

            if (!in_array($file->getClientMimeType(), $allowed)) {
                $json['error'] = lang('tool/upload.error_filetype');
            }

            if (! $file->isValid()) {
                $json['error'] = $file->getErrorString() . '(' . $file->getError() . ')';
            }

            if (! $json) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    $uploadModel = new UploadModel();

                    $newName = $file->getRandomName();

                    $folder = WRITEPATH . 'uploads/project-' . $project_id;

                    if (is_dir($folder)) {
                        $file->move($folder, $newName);
                    } else {
                        mkdir(WRITEPATH . 'uploads/project-' . $project_id, 0777);
                        $file->move($folder, $newName);
                    }

                    $json['initialPreview'] = '';

                    $json['initialPreviewConfig'][] = [
                            'type'     => 'image',      
                            'caption'  => $file->getClientName(),
                            'key'      => $newName,
                            'fileId'   => $newName, 
                            'size'     => $file->getSize(),
                            'url'      => base_url('tool/upload/remove?freelancer_id=' . $customer_id . '&project_id=' . $project_id),
                    ];

                    $json['append'] = true;

                    $data = [
                        'project_id'    => $project_id,
                        'freelancer_id' => $customer_id,
                        'filename'      => $file->getClientName(),
                        'code'          => 'project-' . $project_id . '/' . $newName,
                        'type'          => $file->getClientMimeType(),
                        'ext'           => $file->getClientExtension(),
                        'size'          => $file->getSize()
                    ];
                    // check if uploading attachment or project files
                    if ($this->request->getVar('type')) {
                        $json['download_id'] = $uploadModel->addAttachment($data);
                    } else {
                        $uploadModel->insert($data);
                    }

                    $json['success'] = lang('tool/upload.text_upload');
                }
            }
        }
        return $this->response->setJSON($json);
    }

    public function remove()
    {
        $json = [];

        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            if ($this->request->getVar('freelancer_id') && $this->request->getVar('project_id')) {
                $projectModel = new ProjectModel();

                $upload_info = $projectModel->getProjectUploadedFile($this->request->getVar('project_id'), $this->request->getVar('freelancer_id'));

                if ($upload_info) {
                    $file = WRITEPATH . 'uploads/' . $upload_info['code'];
                    if (file_exists($file)) {
                        unlink($file);
                        $projectModel->deleteProjectFiles($this->request->getVar('project_id'), $this->request->getVar('freelancer_id'));
                    } else {
                        $projectModel->deleteProjectFiles($this->request->getVar('project_id'), $this->request->getVar('freelancer_id'));
                    }
                } else {
                        $json['error'] = 'Error: Please contact system administrator';
                }
            }
        }
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
