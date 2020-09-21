<?php namespace Admin\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class Permission implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // Override Login Page
        if (current_url() == slash_item('baseURL')) {
            return;
        }

        $session = \Config\Services::session();
        $user = new \Admin\Libraries\User();
        $loader = Services::locator(true);

        $controller = $loader->locateFile(ucfirst($request->uri->getSegment(3)), 'Controllers/'. ucfirst($request->uri->getSegment(1)) . '/' . ucfirst($request->uri->getSegment(2)));

        // get Correct Routes
        if ($controller) {
            $route = $request->uri->getSegment(1) . '/' . $request->uri->getSegment(2) . '/' . $request->uri->getSegment(3);
        } else {
            $route = $request->uri->getSegment(1) . '/' . $request->uri->getSegment(2);
        }

        if (! $route) {
            throw new \Exception("Error: Route couldn't be found");
        }

        // Ignore Some Pages for Token Check
        if ($route) {
            $ignore = array(
            'common/dashboard',
            'common/login',
            'common/logout',
            'common/forgotten',
            'error/not_found',
            'error/permission'
        );


            // redirect if not logged in or token expired
            if (!in_array($route, $ignore) && (! $user->isLogged() || ! $session->get('user_token') || ! $request->getVar('user_token') || ($session->get('user_token') != $request->getVar('user_token')))) {
                return redirect()->to(base_url('index.php/common/login?redirect=' . $route))
                                 ->with('error', lang('en.error.error_token'));
            }
        } else {
            if (! $request->getVar('user_token') || ! $session->get('user_token') || ($request->getVar('user_token') != $session->get('user_token'))) {
                return redirect()->to(base_url('index.php/common/login?redirect=' . $route))
                                 ->with('error', lang('en.error.error_token'));
            }
        }

        // Check Access Permission
        if ($route) {
            if (!in_array($route, $ignore) && !$user->hasPermission('access', rtrim($route, '/'))) {
                return redirect()->to(base_url('index.php/error/permission?user_token='.$session->get('user_token')));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Nothing here
    }

    // ----------------------------------------------------
}
