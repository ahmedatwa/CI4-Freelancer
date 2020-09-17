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
 * that you'd like to use throughout your entire Cataloglication
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */
use Config\Services;

 /**
 * Short Date Format
 *
 * @param string   $where  Where something interesting takes place
 * @throws Exception If something interesting cannot hCatalogen
 * @return string
 **/
if (!function_exists('DateShortFormat')) {
    function DateShortFormat(string $date)
    {
        if (!$date) {
            throw new \Exception("Date is missing in function!");
        }
        $fmt = date_create($date);
        return date_format($fmt, lang(config('Catalog')->defaultLocale . '.date_format_short'));
    }
}


if (! function_exists('img_url')) {
    function img_url(string $image)
    {
        return base_url('catalog/' . \Catalog\Libraries\Registry::get('config_theme').'/img/' . $image);
    }
}

if (! function_exists('formError')) {
    function formError(string $name)
    {
        $validation =  \Config\Services::validation();
        if ($validation->hasError($name)) {
            return "<span class='text-danger'>" . $validation->getError(esc($name)) . "</span>";
        }
    }
}

if (! function_exists('getKeywordByQuery'))
{
    function getKeywordByQuery($keyword)
    {
        $seo_urls = new \Catalog\Models\Design\Seo_urls;
        $segment = $seo_urls->getKeywordByQuery($keyword);
        if ($segment) {
            return $segment;
        } else {
            return null;
        }
    }
}

// Override the View function to extend it with theme name
if (! function_exists('view')) {
    function view(string $name, array $data = [], array $options = [])
    {
        if (config('App')->templateEngine == 'twig') {
            // specify where to look for templates
            $loader = new \Twig\Loader\FilesystemLoader(config('paths')->viewDirectory);

            // initialize Twig environment
            $config = [
                'charset'     => 'utf-8',
                'autoescape'  => false,
                'debug'       => false,
                'auto_reload' => true,
                'cache'       => config('paths')->writableDirectory . '/cache/'
            ];

            $twig  = new \Twig\Environment($loader, $config);
            return $twig->render(service('registry')->get('config_theme') . '/' . $name . '.twig', $data);
        } else {
            /**
             * @var CodeIgniter\View\View $renderer
             */
            $renderer = Services::renderer();

            $saveData = config(View::class)->saveData;

            if (array_key_exists('saveData', $options)) {
                $saveData = (bool) $options['saveData'];
                unset($options['saveData']);
            }

            return $renderer->setData($data, 'raw')
                    ->render(service('registry')->get('config_theme') . '/' . $name, $options, $saveData);
        }
    }
}
