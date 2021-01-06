<?php namespace Catalog\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Catalog\Models\Localization\LanguageModel;

class Localization implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $languageModel = new LanguageModel();
        
        $registry = service('registry');
        $session = service('session');

        $language = \Config\Services::language();

        $supportedLocales = $request->config->supportedLocales;

        $defaultLocale = $request->config->defaultLocale;

        if ($session->get('language')) {
            $language_info = $languageModel->getLanguageByCode($session->get('language'));

            $locale  = $language_info['code'];

            if (in_array($locale, $supportedLocales)) {
                $language->setLocale($session->get('language'));
                $registry->set('config_language_id', $language_info['language_id']);
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
