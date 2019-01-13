<?php
namespace Modules\Winter\Controllers;

use Modules\Winter\Models\Media;
use Modules\Winter\Models\Attachment;
use Modules\Winter\Models\Post;
use Phact\Exceptions\HttpException;

class ApiController extends AuthController
{
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
     * @return array
     */
    public function _loadFile()
    {
        $file = new Attachment();
        return $file->loader($_FILES['f']);
    }

    /**
     * @return array
     */
    public function _loadImage()
    {
        $img = new Media();
        return $img->loader($_POST['m']);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function _create()
    {
        $post = new Post();
        return $this->_router->url('winter:editor', ['id' => $post->save()]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function _logout()
    {
        $this->_auth->logout();
        return $this->_router->url('winter:index');
    }
}