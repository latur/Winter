<?php
namespace Modules\Winter\Controllers;

use Modules\Winter\Models\Media;
use Modules\Winter\Models\Attachment;
use Modules\Winter\Models\Post;
use Phact\Controller\Controller;
use Phact\Interfaces\AuthInterface;
use Phact\Request\HttpRequestInterface;
use Phact\Template\RendererInterface;

class AuthController extends Controller
{
    /**
     * @var AuthInterface
     */
    protected $_auth;
    protected $_request;

    /**
     * AuthController constructor.
     * @param HttpRequestInterface $request
     * @param AuthInterface $auth
     * @param RendererInterface $renderer
     */
    public function __construct(HttpRequestInterface $request, AuthInterface $auth, RendererInterface $renderer)
    {
        $this->_auth = $auth;
        $this->_request = $request;
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

    public function image()
    {
        $this->_request->validateCsrfToken();
        $img = new Media();
        echo json_encode($img->loader($_POST['m']));
    }

    public function file()
    {
        $this->_request->validateCsrfToken();
        $file = new Attachment();
        echo json_encode($file->loader($_FILES['f']));
    }

    public function save()
    {
        $this->_request->validateCsrfToken();
        $post = Post::objects()->get();
        $post->saveContent();
    }
}