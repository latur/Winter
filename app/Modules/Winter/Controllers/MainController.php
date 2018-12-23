<?php
namespace Modules\Winter\Controllers;

use Modules\Winter\Forms\LoginForm;
use Modules\Winter\Models\Post;
use Phact\Controller\Controller;
use Phact\Interfaces\AuthInterface;
use Phact\Request\HttpRequestInterface;
use Phact\Template\RendererInterface;

class MainController extends Controller
{
    /**
     * @var AuthInterface
     */
    protected $_auth;

    public function __construct(HttpRequestInterface $request, AuthInterface $auth, RendererInterface $renderer)
    {
        $this->_auth = $auth;
        parent::__construct($request, $renderer);
    }

    /**
     * @throws \Phact\Exceptions\DependencyException
     */
    public function index()
    {
        echo $this->render('winter/index.tpl', [
            'posts' => Post::objects()->filter([
                'is_draft' => false
            ])->all()
        ]);
    }

    /**
     * @param $slug
     * @return bool
     * @throws \Phact\Exceptions\DependencyException
     */
    public function post($slug)
    {
        $post = Post::objects()->filter([
            'slug' => $slug,
            'is_draft' => false
        ])->get();

        if (!$post) return false;

        echo $this->render('winter/post.tpl', [
            'post' => $post
        ]);
    }

    /**
     * @throws \Phact\Exceptions\DependencyException
     */
    public function login()
    {
        $user = $this->_auth->getUser();
        if (!$user->getIsGuest()) {
            $this->redirect('winter:index');
        }
        $form = new LoginForm([], $this->_auth);
        if ($this->request->getIsPost() && $form->fill($_POST)) {
            $this->request->validateCsrfToken();
            if ($form->valid) {
                $form->login();
                $this->redirect('winter:index');
            }
        }
        echo $this->render('winter/login.tpl', [
            'form' => $form
        ]);
    }
}
