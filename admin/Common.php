<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

use CodeIgniter\I18n\Time;

if (!function_exists('token')) {
    function token(string $type, int $len)
    {
        if (! $type || ! $len) {
            throw new \Exception("Token Type or length isn't specified");
        }

        helper('text');

        switch ($type) {
        case 'alpha':
             return random_string('alpha', $len);break;
        case 'alnum':
            return random_string('alnum', $len);break;
        case 'basic':
            return random_string('basic', $len);break;
        case 'numeric':
            return random_string('numeric', $len);break;
        case 'nozero':
            return random_string('nozero', $len);break;
        case 'md5':
            return random_string('md5', $len);break;
        case 'sha1':
            return random_string('sha1', $len);break;
        }
    }
}

if (!function_exists('verifyHashedPassword')) {
    function verifyHashedPassword(string $password, string $hashedPassword)
    {
        if (!$password || !$hashedPassword) {
            throw new \Exception("Please add the desired Password and hash to be verified");
        }
        return password_verify($password, $hashedPassword) ? true : false;
    }
}

if (! function_exists('form_error')) {
    function form_error(string $name)
    {
        $validation =  \Config\Services::validation();
        if ($validation->hasError($name)) {
            return "<span class='text-danger'>" . $validation->getError(esc($name)) . "</span>";
        }
    }
}

if (! function_exists('img_url')) {
    function img_url(string $image)
    {
        return base_url('assets/images/' . $image);
    }
}

if (!function_exists('currency_format')) {
    function currency_format(float $num, string $currency = 'EGP')
    {
        return number_format($num, 2) .' ' . service('registry')->get('config_currency');
    }
}

if (! function_exists('resizeImage')) {
    function resizeImage(string $filename, int $width, int $height)
    {
        if (!is_file(DIR_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $filename)), 0, strlen(DIR_IMAGE)) != str_replace('\\', '/', DIR_IMAGE)) {
            return;
        }

        // get the image extension
        $image_extension = pathinfo($filename, PATHINFO_EXTENSION);
        //get the image name
        $image_old = $filename;

        // store resized images in new cach path with the same folder names
        $image_new = 'cache/' . substr($image_old, 0, strrpos($image_old, '.')) . '-' . $width . 'x' . $height . '.' . $image_extension;

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
                $path =  $path . '/' . $directory;

                if (!is_dir(DIR_IMAGE . ltrim($path, '/'))) {
                    @mkdir(rtrim(DIR_IMAGE, '/') . $path, 0777);
                }
            }

            // Resize the image
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
        // return the image href
        return config('App')->httpCatalog . 'images/' . $image_new;
    }
}

if (! function_exists('generateSeoUrl')) {
    function generateSeoUrl(string $string)
    {
        helper('text');
        return url_title(convert_accented_characters($string), '-', true);
    }
}

/**
 * Short Date Format
 * @var date int
 * @return string|int
 **/
if (!function_exists('dateFormatShort')) {
    function dateFormatShort(int $date)
    {
        if (extension_loaded('intl')) {
           return lang(config('App')->defaultLocale . '.short_date', [$date]);
        } else {
           return $date;
        }
    }
}
/**
 * Short Date Format
 * @var date int
 * @return string
 **/
if (! function_exists('dateFormatLong')) {
    function dateFormatLong(int $date): string
    {
        if (extension_loaded('intl')) {
            return lang(config('App')->defaultLocale . '.medium_date', [$date]) . ' ' . lang('en.short_time', [$date]);
        } else {
            return $date;
        }
    }
}
