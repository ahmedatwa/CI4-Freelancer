<?php namespace Catalog\Controllers\Tool;

use \Catalog\Models\Tool\DownloadModel;

class Download extends \Catalog\Controllers\BaseController
{
    public function index()
    {  
        $downloadModel = new DownloadModel();
      
        if (!$this->customer->isLogged()) {
            return redirect('account_login');
        }

        if ($this->request->getVar('download_id')) {
            $download_id = $this->request->getVar('download_id');
        } else {
            $download_id = 0;
        }

        $download_info = $downloadModel->find($download_id);

        if ($download_info) {

            $file = WRITEPATH . 'uploads/' . $download_info['code'];

            if (!headers_sent()) {

                if (file_exists($file)) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . (basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));

                    if (ob_get_level()) {
                        ob_end_clean();
                    }

                    readfile($file, 'rb');

                    exit();
                } else {
                    throw new \Exception('Error: Could not find file ' . $file . '!');
                }
            } else {
                throw new \Exception('Error: Headers already sent out!');
            }
        } else {
            throw new \Exception('Error: Please contact system administrator');
        }
    }


    //--------------------------------------------------------------------
}
