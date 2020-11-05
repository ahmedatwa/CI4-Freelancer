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

if (! function_exists('formError')) {
    function formError(string $name)
    {
        $validation =  \Config\Services::validation();
        if ($validation->hasError($name)) {
            return "<span class='text-danger'>" . $validation->getError(esc($name)) . "</span>";
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
/**
@ return string
@ var date string
@ return the Days Left for the project to be closed
**/
if (! function_exists('getDaysLeft')) {
    function getDaysLeft(string $date)
    {
        $time = new CodeIgniter\I18n\Time();

        $now = $time::now();
        $diff = $now->difference($time::parse($date));
        return $diff->humanize();
    }
}

// Graduation Year
if (!function_exists('seller_graduation_year')) {
    function seller_graduation_year()
    {
        $json = [];
        $cur_year = date('Y');
        $years = range($cur_year, $cur_year-50);

        foreach ($years as $year) {
            $json[] = [
               'id' => $year,
               'text' => $year
           ];
        }
        return $json;
    }
}

// Countires
if (!function_exists('seller_countries_list')) {
    function seller_countries_list()
    {
        $countries = ['Algeria', 'Bahrain', 'Egypt', 'Iraq', 'Jordan', 'Kuwait', 'Lebanon', 'Libya', 'Morocco', 'Oman', 'Palestine', 'Qatar', 'Saudi Arabia', 'Sudan', 'Syria', 'Tunisia', 'United Arab Emirates', 'Yemen'];
        
        sort($countries);
        return $countries;
    }
}


