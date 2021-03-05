<?php

namespace Catalog\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use \Catalog\Models\Localization\CurrencyModel;
use CodeIgniter\I18n\Time;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
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
    protected $helpers = ['text'];
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
        $this->session  = \Config\Services::session();
        $language       = \Config\Services::language();
        $this->locale   = $language->getLocale();
        $this->registry = service('registry');
        $this->template = service('template');
        $this->customer = service('customer');
    }

    public function resize(string $filename, int $width = 0, int $height = 0)
    {
        if (!is_file(DIR_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $filename)), 0, strlen(DIR_IMAGE)) != str_replace('\\', '/', DIR_IMAGE)) {
            return;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_old = $filename;
        $image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
   

        if (! is_file(DIR_IMAGE . $image_new) || (filemtime(DIR_IMAGE . $image_old) > filemtime(DIR_IMAGE . $image_new))) {
            // Assign variables as if they were an array:
            list($original_width, $original_height, $original_type) = getimagesize(DIR_IMAGE . $image_old);

            // double check type is extension
            if (! in_array($original_type, [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_BMP])) {
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

    public function dateAfter(string $date_end): bool
    {
        return Time::now()->isAfter(Time::createFromTimestamp($date_end));
    }

    public function dateModify(string $data_added, int $num): string
    {
        $time = Time::createFromTimestamp($data_added);
        $time->subDays($num);
        return $time->toDateTimeString();
    }

    public function dateDifference(string $date_added, int $runtime = 0)
    {

        if ($runtime == 0) {
            $date = Time::createFromTimestamp($date_added);
            return $date->humanize();
        }

        $time = Time::createFromTimestamp($date_added);
        // the bidding endDate
        $diff = Time::today()->difference($time->addDays($runtime)->toDateTimeString());

        return [
            $diff->getDays(), 
            $diff->getHours()
        ];
    }

    public function addDays(string $date_added, string $runtime): string
    {
        $time = Time::createFromTimestamp($date_added);

        $_ = $time->addDays($runtime);

        return $_->getTimestamp();
    }

    public function currencyFormat(float $number, int $fraction = 2): string
    {
        $currencyModel = new CurrencyModel();

        if ($this->request->getCookie(config('App')->cookiePrefix . 'currency')) {
            $code = \Config\Services::encrypter()->decrypt(base64_decode($this->request->getCookie(config('App')->cookiePrefix . 'currency', FILTER_SANITIZE_STRING)));
        } else {
            $code = $this->registry->get('config_currency');
        }

        $currency_info = $currencyModel->getCurrencyByCode($code);

        helper('number');

        $value = $currency_info['value'] ? (float) $number * $currency_info['value'] : (float) $number;

        if ($this->request->getCookie(config('App')->cookiePrefix . 'currency')) {
            return number_to_currency($value, $code, $this->locale, $fraction);
        } else {
            return number_to_currency($number, $code, $this->locale, $fraction);
        }
    }
    // -----------------------------------------------------------------
}
