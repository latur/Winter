<?php
namespace Modules\Winter\Controllers;

use Modules\Winter\Models\Media;
use Modules\Winter\Models\Attachment;
use Modules\Winter\Models\Post;
use Phact\Controller\Controller;
use Phact\Interfaces\AuthInterface;
use Phact\Main\Phact;
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
        $post = Post::objects()->get();
        echo $this->render('winter/index.tpl', [
            'post' => $post
        ]);
    }
}