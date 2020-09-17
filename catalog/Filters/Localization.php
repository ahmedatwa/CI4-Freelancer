<?php namespace Catalog\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Catalog\Models\Localisation\Language;
use Config\Services;

class Localization implements FilterInterface
{
    public function before(RequestInterface $request)
    {

        $language_model = new Language();
        $registry = service('registry');

        $supportedLocales = $request->config->supportedLocales;

        if (sizeof($supportedLocales) > 1) {
            $language = $language_model->getLanguageByCode($request->getLocale());

            if ($language['language_id'] && $request->getLocale()) {
                $registry->set('config_language_id', $language['language_id']);
            } else {
                $registry->set('config_language_id', $language_model->getLanguages($request->config->defaultLocale));
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
