<?php
namespace Modules\Winter\Models;

use Phact\Main\Phact;
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
            'slug' => [
                'label' => self::t('Winter', 'Post slug'),
                'class' => CharField::class,
                'null' => true,
            ],
            'title' => [
                'label' => self::t('Winter', 'Post title'),
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

    public static function saveChanges($object)
    {
        $model = Phact::app()->request->post->get('model');
        if (!$model) return;
        $object->spec = $model['spec'];
        $object->save();
    }

    public function getContent($editable = false)
    {
        $html = '';
        if (!is_array($this->spec)) return $html;
        foreach ($this->spec as $item) {
            $html .= self::renderTemplate("parts/_spec.tpl", [
                'editable' => $editable,
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