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
        $this->locale   = $this->request->getLocale();
        $this->registry = service('registry');
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

    public function currencyFormat(float $num)
    {
        helper('number');
        return number_to_currency($num, $this->registry->get('config_currency'), $this->locale);
    }

    public function dateAfter(string $date_end)
    {
        $time  = new \CodeIgniter\I18n\Time;

        $time1 = $time::now();
        $time2 = $time::parse($date_end);

        return $time1->isAfter($time2);

    }
    public function dateDifference(string $added, string $end = null)
    {
        $time  = new \CodeIgniter\I18n\Time;

        if (!$end) {
           $date = $time::parse($added);
           return $date->humanize();
        }

        $date_added = $time::parse($added);
        $date_end   = $time::parse($end);

        $diff = $date_added->difference($date_end);

        return 'Open - ' . $diff->getDays() . ' Days left'; 
    }

    // -----------------------------------------------------------------
}
