<?php namespace Catalog\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Catalog\Models\Localization\LanguageModel;

class Localization implements FilterInterface
{
    public function before(RequestInterface $request)
    {

        $languageModel = new LanguageModel();
        $registry = service('registry');

        $supportedLocales = $request->config->supportedLocales;

        if (sizeof($supportedLocales) > 1) {
            $language = $languageModel->getLanguageByCode($request->getLocale());

            if ($language['language_id'] && $request->getLocale()) {
                $registry->set('config_language_id', $language['language_id']);
            } else {
                $registry->set('config_language_id', $languageModel->getLanguages($request->config->defaultLocale));
            }
            if ($request->uri->getTotalSegments() > 0 && !in_array($request->uri->getSegment(1), $supportedLocales)) {
                //var_dump(uri_string());
                //return redirect('/');
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}
