<?php namespace Admin\Controllers;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
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
    protected $helpers = [];
    protected $document;
    protected $registry;
    protected $user;

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
        $this->document = new \Admin\Libraries\Document();
        $this->registry = new \Admin\Libraries\Registry();
        $this->user     = new \Admin\Libraries\User();
    }
    
    public function paginationInitilize($page, $limit, $total)
    {
        $pager = \Config\Services::pager();
        return ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);
    }

    public function paginationText($total, $page, $limit)
    {
        return sprintf(lang('en.list.text_pagination'), $page, (($total >= $limit) ? $limit : $total), $total);
    }

    /***
    // return string of current route controller path without methods
    // unlike getPath return full path
    @ return string
    */
    public function getRoute(): string
    {
        $route  = $this->request->uri->getSegment(1) . '/' . $this->request->uri->getSegment(2);
        if ($route) {
            return (string)$route;
        }
    }
    /**
    @ return the Bid Open Days
    **/
    public function getOpenDays(string $start, string $end): string
    {
        return ceil(abs(strtotime($start) - strtotime($end)) / 86400);
    }
    

    // ---------------------------------------------------------------------------------
}
