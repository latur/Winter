<?php
namespace Modules\Winter\Controllers;

use Modules\Winter\Forms\SettingsForm;
use Modules\Winter\Models\Media;
use Modules\Winter\Models\Attachment;
use Modules\Winter\Models\Post;
use Phact\Controller\Controller;
use Phact\Exceptions\HttpException;
use Phact\Interfaces\AuthInterface;
use Phact\Request\HttpRequestInterface;
use Phact\Router\Router;
use Phact\Template\RendererInterface;

class AuthController extends Controller
{
    /**
     * @var AuthInterface
     */
    protected $_auth;
    protected $_router;


    /**
     * AuthController constructor.
     * @param HttpRequestInterface $request
     * @param AuthInterface $auth
     * @param RendererInterface $renderer
     * @param Router $router
     */
    public function __construct(HttpRequestInterface $request, AuthInterface $auth, RendererInterface $renderer, Router $router)
    {
        $this->_auth = $auth;
        $this->_router = $router;
        parent::__construct($request, $renderer);
    }


    /**
     * @param $action
     * @param $params
     * @throws \Exception
     * @throws \Phact\Exceptions\HttpException
     */
    public function beforeAction($action, $params)
    {
        $user = $this->_auth->getUser();
        if (!$user || $user->getIsGuest()) $this->error(405);
    }
}