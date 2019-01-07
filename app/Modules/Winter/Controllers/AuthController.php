<?php
namespace Modules\Winter\Controllers;

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


    /**
     * @throws HttpException
     */
    public function api()
    {
        if (!$this->request->getIsPost()) $this->error(405);
        $this->request->validateCsrfToken();
        $method = "_" . $this->request->post->get('method');
        if (method_exists($this, $method)) echo json_encode($this->{$method}());
    }


    /**
     * @return \Doctrine\DBAL\Driver\Statement|int|string
     */
    public function _setActive()
    {
        return Post::objects()->filter([
            'id' => $this->request->post->get('id')
        ])->update([
            'active' => $this->request->post->get('to') ? 1 : 0
        ]);
    }

    /**
     * @throws \Phact\Exceptions\DependencyException
     */
    public function drafts()
    {
        echo $this->render('winter/drafts.tpl', [
            'posts' => Post::objects()->filter([
                'is_draft' => true
            ])->all()
        ]);
    }

    /**
     * @throws \Phact\Exceptions\DependencyException
     */
    public function stat()
    {
        echo $this->render('winter/stat.tpl', []);
    }


    /**
     * @param $id
     * @return mixed
     * @throws \Phact\Exceptions\DependencyException
     * @throws HttpException
     */
    public function editor($id)
    {
        $post = Post::objects()->filter(['id' => $id])->get();
        if ($this->request->getIsPost()) {
            $this->validate();
            $post->saveContent();
            return $this->jsonResponse($post->getUrl());
        }

        echo $this->render('winter/editor.tpl', [
            'post' => $post
        ]);
    }

    /**
     * @throws HttpException
     */
    protected function validate()
    {
        if ($this->request->getIsPost()) return $this->request->validateCsrfToken();
        throw new HttpException(400, 'POST Method only');
    }

    /**
     * @throws HttpException
     */
    public function image()
    {
        $this->validate();
        $img = new Media();
        echo json_encode($img->loader($_POST['m']));
    }

    /**
     * @throws HttpException
     */
    public function file()
    {
        $this->validate();
        $file = new Attachment();
        echo json_encode($file->loader($_FILES['f']));
    }

    /**
     * @throws HttpException
     * @throws \Exception
     */
    public function create()
    {
        $this->validate();
        $post = new Post();
        echo json_encode($this->_router->url('winter:editor', ['id' => $post->save()]));
    }

    /**
     * @throws HttpException
     * @throws \Exception
     */
    public function logout()
    {
        $this->validate();
        $this->_auth->logout();
        echo json_encode($this->_router->url('winter:index'));
    }
}