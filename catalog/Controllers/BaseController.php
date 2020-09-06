<?php
namespace Catalog\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

class BaseController extends \CodeIgniter\Controller
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        $this->template = new \Catalog\Libraries\Template();
        $this->customer = new \Catalog\Libraries\Customer();
        $this->session  = \Config\Services::session();

       // $this->url->addrewrite($this);
        

        // if ($this->request->uri->getPath()) {
        //     $parts = explode('/', $this->request->uri->getPath());

        //     // remove any empty arrays from trailing
        //     if (strlen(end($parts)) == 0) {
        //         array_pop($parts);
        //     }

        //     foreach ($parts as $part) {

        //             $db = \Config\Database::connect();
        //             $builder = $db->table('seo_url');
        //             $builder->select();
        //             $builder->where('keyword', $part)->where('site_id', 0);
        //             $query = $builder->get();
        //             $row = $query->getRowArray();

        //             $url = explode('=', $row['query']);

        //             if ($url[0] == 'information_id') {
        //                 $this->request->setGlobal('get', [$url[0] => $url[1]]);
        //             }

        //             //var_dump($this->request->fetchGlobal('get'));

        //             if ($url[0] == 'category_id') {
        //                 $this->request->setGlobal('get', [$url[0] => $url[1]]);
        //             }


        //          if ($row['query']  ) {

        //                // $this->request->setGlobal('get', ['path' => $row['path']]);
        //             }

        //     }
        // }

    }

    public function resize(string $filename, int $width = 0, int $height = 0)
    {
        if (!is_file(DIR_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $filename)), 0, strlen(DIR_IMAGE)) != str_replace('\\', '/', DIR_IMAGE)) {
            return;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_old = $filename;
        $image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
   

        if (!is_file(DIR_IMAGE . $image_new) || (filemtime(DIR_IMAGE . $image_old) > filemtime(DIR_IMAGE . $image_new))) {
            // Assign variables as if they were an array:
            list($original_width, $original_height, $original_type) = getimagesize(DIR_IMAGE . $image_old);

            // double check type is extension
            if (!in_array($original_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_BMP))) {
                return DIR_IMAGE . $image_old;
            }
 
            $path = '';
            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!is_dir(DIR_IMAGE . $path)) {
                    @mkdir(DIR_IMAGE . $path, 0777);
                }
            }

            //Resize the image otherwise get the errors
            if ($original_width != $width || $original_height != $height) {
                try {
                    \Config\Services::image()->withFile(DIR_IMAGE . $image_old)
                   ->resize($width, $height, false, 'height')
                   ->save(DIR_IMAGE . $image_new);
                } catch (CodeIgniter\Images\ImageException $e) {
                    echo $e->getMessage();
                }
            } else {
                copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);
            }
        }
            return base_url() . '/images/' . $image_new;
    }

//     public function rewrite($link)
//     {
//         $url_info = parse_url(str_replace('&amp;', '&',  (string) $link));

//         $url = '';

//         $data = [];

//         if (isset($url_info['path']) && isset($url_info['query'])) {
//                array_push($data, $url_info['path'], $url_info['query']);
//         }

//         if (!empty($data)) {

//             if ($data[0]) {
//                 $vars =  explode('=', $data[1]);

//                 $this->request->setGlobal('get', [$vars[0] => $vars[1]]);

//                 if (($data[0] == '/information/information' && substr($data[1], 0, strpos($data[1], '=')) == 'information_id') || ($data[0] == '/project/category' && substr($data[1], 0, strpos($data[1], '=')) == 'category_id')) {
                    

//                     $db = \Config\Database::connect();
//                     $builder = $db->table('seo_url');
//                     $builder->select();
//                     $builder->where('query', $data[1])->where('site_id', 0)->where('language_id', 1);
//                     $query = $builder->get();
//                     $row = $query->getRowArray();
//                     $url = $row['keyword'];
//                 }
//             }
//          }

//         if ($url) {
//            // var_dump($url);
  
//         unset($data['path']);

//         $config = \CodeIgniter\Config\Services::request()->config;

//         // If baseUrl does not have a trailing slash it won't resolve
//         // correctly for users hosting in a subfolder.
//         $baseUrl = ! empty($config->baseURL) && $config->baseURL !== '/'
//             ? rtrim($config->baseURL, '/ ') . '/'
//             : $config->baseURL;

//         unset($config);
//         return $baseUrl . (string) $url;



        
//     }
// }

    // -----------------------------------------------------------------
}
