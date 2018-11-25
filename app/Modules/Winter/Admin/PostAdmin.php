<?php
namespace Modules\Winter\Admin;

use Modules\Admin\Contrib\Admin;
use Modules\Winter\Models\Post;

class PostAdmin extends Admin
{
    public function getSearchColumns()
    {
        return ['title'];
    }

    public function getModel()
    {
        return new Post;
    }

    public function getName()
    {
        return $this->t('Winter', 'Posts');
    }

    public function getItemName()
    {
        return $this->t('Winter', 'Post');
    }
}