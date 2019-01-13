<?php
namespace Modules\Winter\Controllers;

use Modules\Winter\Forms\SettingsForm;
use Modules\Winter\Models\Post;

class AdminController extends AuthController
{
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
     * @throws \Phact\Exceptions\DependencyException
     */
    public function settings()
    {
        $form = new SettingsForm();
        if ($this->request->getIsPost() && $form->fill($_POST)) {
            $this->request->validateCsrfToken();
            if ($form->valid) {
                $form->save();
            }
        }
        echo $this->render('winter/settings.tpl', [
            'form' => $form
        ]);
    }


    /**
     * @param $id
     * @return mixed
     * @throws \Phact\Exceptions\DependencyException
     */
    public function editor($id)
    {
        $post = Post::objects()->filter(['id' => $id])->get();
        if ($this->request->getIsPost()) {
            // $this->validate();
            $post->saveContent();
            return $this->jsonResponse($post->getUrl());
        }

        echo $this->render('winter/editor.tpl', [
            'post' => $post
        ]);
    }
}
