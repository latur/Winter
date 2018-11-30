<?php
namespace Modules\Winter\Models;

use Phact\Orm\Fields\CharField;
use Phact\Orm\Fields\JsonField;
use Phact\Orm\Model;
use Phact\Template\Renderer;
use Phact\Translate\Translator;

class Post extends Model
{
    use Renderer;
    use Translator;

    public static function getFields()
    {
        return [
            'title' => [
                'label' => self::t('Winter', 'Post title'),
                'class' => CharField::class,
                'null' => true,
            ],
            'slug' => [
                'label' => self::t('Winter', 'Post slug'),
                'class' => CharField::class,
                'null' => true,
            ],
            'content' => [
                'label' => self::t('Winter', 'Post content'),
                'class' => JsonField::class,
                'null' => true,
            ],
        ];
    }

    public function saveContent()
    {
        $this->content = isset($_POST['content']) ? $_POST['content'] : [];
        $this->title = mb_substr($_POST['title'], 0, 255);
        $this->save();
    }

    public function getContent()
    {
        if (!is_array($this->content)) return null;
        $html = '';
        foreach ($this->content as $item) {
            if (!in_array($item['type'], ['file','video','text','image','points'])) continue ;
            $html .= self::renderTemplate("block/{$item['type']}.tpl", [
                'item' => $item
            ]);
        }
        return $html;
    }

    public function __toString()
    {
        return (string) $this->title;
    }
}