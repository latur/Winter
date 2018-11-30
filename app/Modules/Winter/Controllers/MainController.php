<?php
namespace Modules\Winter\Controllers;

use Modules\Winter\Models\Media;
use Modules\Winter\Models\Attachment;
use Modules\Winter\Models\Post;
use Phact\Controller\Controller;
use Phact\Main\Phact;

class MainController extends Controller
{

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

    public function upload()
    {
        $img = new Media();
        echo json_encode($img->loader($_POST['m']));
    }

    public function file()
    {
        $file = new Attachment();
        echo json_encode($file->loader($_FILES['f']));
    }

    public function save()
    {
        $post = Post::objects()->get();
        $post->saveContent();
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