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
use CodeIgniter\I18n\Time;

// Override the View function to extend it engine and templating
if (! function_exists('view')) {
    function view(string $name, array $data = [], array $options = [])
    {
        // merge the langData if sent from controller
        if (isset($data['langData'])) {
            $data = array_merge($data['langData'], $data);
        }

        if (config('Config')->templateEngine == 'twig') {
            // specify where to look for templates
            $loader = new \Twig\Loader\FilesystemLoader(config('paths')->viewDirectory);

            // initialize Twig environment
            $config = [
                'charset'     => 'utf-8',
                'autoescape'  => false,
                'debug'       => ENVIRONMENT !== 'production',
                'auto_reload' => true,
                'cache'       => config('paths')->writableDirectory . '/cache/'
            ];

            $twig  = new \Twig\Environment($loader, $config);
            // CI PHP functions
            $functions_safe = ['csrf_field', 'csrf_token', 'csrf_hash'];
            foreach ($functions_safe as $value) {
                if (function_exists($value)) {
                    $twig->addFunction(
                        new \Twig\TwigFunction($value, $value, ['is_safe' => ['html']])
                    );
                }
            }

            return $twig->render(service('registry')->get('config_theme') . '/' . $name . '.twig', $data);
        } else {
            /**
             * @var CodeIgniter\View\View $renderer
             */
            $renderer = Services::renderer();
            //var_dump($renderer);
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

// getDaysLeft
if (! function_exists('getDaysLeft')) {
    /**
    * @var string date
    * @return string
    * get the Days Left for the project to be closed
    */
    function getDaysLeft(string $date): string
    {
        $now  = Time::now();
        $diff = $now->difference(Time::parse($date));
        return $diff->humanize();
    }
}

// Years
if (! function_exists('getYears')) {
    /**
    * @var int number
    * @return array
    */
    function getYears(int $number = 50): array
    {  
        $years = [];

        $time        = Time::now();
        $currentYear = $time->getYear();
        $results     = range($currentYear, $currentYear - $number);
        foreach ($results as $result) {
            $years[] = [
               'id'   => $result,
               'text' => $result
           ];
        }
        return $years;
    }
}

if (! function_exists('getDateTimeString')) {
    /**
    * @var int number
    * @return array
    */
    function getDateTimeString(int $date, int $runtime): string
    {
        $date_added = Time::createFromTimestamp($date);
        $date_string = $date_added->addDays($runtime);
        return str_replace('-', '/', $date_string->toDateString());
    }
}
