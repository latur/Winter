<?php
namespace Modules\Winter\Controllers;

use Modules\Winter\Models\Media;
use Modules\Winter\Models\Post;
use Phact\Controller\Controller;
use Phact\Main\Phact;
use Phact\Storage\Files\ResourceFile;

class MainController extends Controller
{

    /**
     * @throws \Phact\Exceptions\DependencyException
     */
    public function index()
    {
        echo $this->render('main/index.tpl');
    }

    public function upload()
    {
        $img = new Media();
        echo json_encode($img->decode($_POST['m']));
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