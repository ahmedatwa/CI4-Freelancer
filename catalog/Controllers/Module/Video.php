<?php namespace Catalog\Controllers\Module;

class Video extends \Catalog\Controllers\BaseController
{
    public function index($setting)
    {
        $data['videos'] = [];

        foreach ($setting['module_description'] as $result) {
            $file = new \CodeIgniter\Files\File(DIR_IMAGE . $result);

            if (in_array($file->getMimeType(), ['video/mp4', 'video/webm'])) {
                $data['videos'][] = [
                    'link' => base_url('images/' . $result),
                    'mime' => $file->getMimeType()
                ];
            }
        }

        $data['background_image'] = $this->resize($setting['module_description']['image'], 846, 415);

        return view('module/video', $data);
    }
}
