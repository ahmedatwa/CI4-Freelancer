<?php namespace Admin\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use \Admin\Libraries\User;

class Permission implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();
        $user = new User();
        $loader = Services::locator(true);

        $segments = $request->uri->getSegments();

        if ($segments) {
            if (in_array('extensions', $segments)) {
                $controller = $loader->locateFile(ucfirst(end($segments)), ucfirst($request->uri->getSegment(1)) . '/Controllers/' . ucfirst($request->uri->getSegment(2)));
            } else {
                $controller = $loader->locateFile(ucfirst($request->uri->getSegment(2)), 'Controllers/' . ucfirst($request->uri->getSegment(1)));
            }
        }
        
        // Check for Main Login Route
        if ($segments) {
            // get Correct Routes
            if (in_array('extensions', $segments)) {
                $route = rtrim($request->uri->getSegment(1) . '/' . $request->uri->getSegment(2) . '/' . $request->uri->getSegment(3), '/');
            } else {
                $route = rtrim($request->uri->getSegment(1) . '/' . $request->uri->getSegment(2), '/');
            }
        } elseif (current_url() == slash_item('baseURL')) {
            $route = 'common/login';
        } else {
            throw new \Exception("Error: No Valid URL Segments!");
        }

        if (! $route) {
            throw new \Exception("Error: Route couldn't be found");
        }

        // Ignore Some Pages for Token Check
        if ($route) {
            $ignore = [
            'common/dashboard',
            'common/login',
            'common/logout',
            'common/forgotten',
            'error/not_found',
            'error/permission'
           ];

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
                return redirect()->to(base_url('index.php/error/permission?user_token=' . $session->get('user_token')));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing here
    }

    // ----------------------------------------------------
}
