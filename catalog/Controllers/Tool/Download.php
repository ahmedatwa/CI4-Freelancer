<?php 

namespace Catalog\Controllers\Tool;

use Catalog\Controllers\BaseController;
use Catalog\Models\Tool\DownloadModel;

class Download extends BaseController
{
    public function index()
    {
        $downloadModel = new DownloadModel();
      
        if (! $this->customer->isLogged()) {
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

            if (! headers_sent()) {
                if (file_exists($file)) {
                    return $this->response->download($file, null);
                } else {
                    throw new \Exception('Error: Could not find file ' . $download_info['filename'] . '!');
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
