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
        echo $this->render('main/index.tpl', [
            'post' => $post
        ]);
    }

    /**
     * @param null $slug
     * @return bool
     * @throws \Phact\Exceptions\DependencyException
     */
    public function post($slug = null)
    {
        echo $this->render('main/index.tpl');
        exit;
        d($slug);
        $product = Post::objects()->filter(['slug' => $slug])->get();
        if (!$product) return false;

        $is_admin = Phact::app()->auth->getUser()->is_superuser;
        $is_editable = Phact::app()->request->get->get('editable');

        if ($is_admin) Post::saveChanges($product);

        echo $this->render('main/main/product.tpl', [
            'editable' => $is_admin && $is_editable,
            'product' => $product
        ]);
    }
}