<?php
namespace Modules\Winter\Models;

use Cocur\Slugify\Slugify;
use Phact\Main\Phact;
use Phact\Orm\Fields\BooleanField;
use Phact\Orm\Fields\CharField;
use Phact\Orm\Fields\DateTimeField;
use Phact\Orm\Fields\IntField;
use Phact\Orm\Fields\JsonField;
use Phact\Orm\Fields\TextField;
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
                'label' => self::t('Winter', 'Title'),
                'class' => CharField::class,
                'null' => true,
            ],
            'introduction' => [
                'label' => self::t('Winter', 'Introduction'),
                'class' => TextField::class,
                'null' => true,
            ],
            'slug' => [
                'label' => self::t('Winter', 'Slug'),
                'class' => CharField::class,
                'null' => true,
            ],
            'min_read' => [
                'label' => self::t('Winter', 'Min read'),
                'class' => IntField::class,
                'default' => 1,
                'null' => true,
            ],
            'content' => [
                'label' => self::t('Winter', 'Content'),
                'class' => JsonField::class,
                'null' => true,
            ],
            'created' => [
                'label' => self::t('Winter', 'Created'),
                'class' => DateTimeField::class,
                'null' => true,
                'autoNowAdd' => true,
            ],
            'updated' => [
                'label' => self::t('Winter', 'Last update'),
                'class' => DateTimeField::class,
                'null' => true,
                'autoNow' => true,
                'autoNowAdd' => true,
            ],
            'is_draft' => [
                'label' => self::t('Winter', 'Is draft'),
                'class' => BooleanField::class,
                'null' => true,
                'default' => true,
            ],
            'active' => [
                'label' => self::t('Winter', 'Is not removed'),
                'class' => BooleanField::class,
                'null' => true,
                'default' => true,
            ],
        ];
    }

    private function makeIntroduction()
    {
        $text = '';
        foreach ($this->content as $item) {
            if ($item['type'] != 'text') continue;
            $text .= strip_tags($item['data']);
        }

        $this->min_read = max(1, round(mb_strlen($text)/1450));

        $this->introduction = "";
        foreach (explode(' ', $text) as $word) {
            if (mb_strlen($this->introduction) > 512) break;
            $this->introduction .= "$word ";
        }
    }

    private function makeSlug()
    {
        $sf = new Slugify();
        $this->slug = mb_substr($sf->slugify($this->title), 0, 225);

        $exists = static::objects()->filter([
            'slug' => $this->slug
        ])->exclude([
            'id' => $this->id
        ])->count();

        if ($exists) {
            $this->slug = $this->slug . "-" . base_convert(uniqid(), 10, 32);
        }
    }

    public function saveContent()
    {
        $this->content = isset($_POST['content']) ? $_POST['content'] : [];
        $this->title = mb_substr($_POST['title'], 0, 255);

        $this->is_draft = false;

        $this->makeSlug();
        $this->makeIntroduction();
        $this->save();
    }

    public function getContent($editable = false)
    {
        if (!is_array($this->content)) return null;
        $html = '';
        foreach ($this->content as $item) {
            if (!in_array($item['type'], ['file','video','text','image','points'])) continue ;
            $html .= self::renderTemplate("editor/{$item['type']}.tpl", [
                'item' => $item,
                'editable' => $editable
            ]);
        }
        return $html;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getUrl()
    {
        if ($this->is_draft) {
            return Phact::app()->router->url('winter:editor', [
                'id' => $this->id,
            ]);
        } else {
            return Phact::app()->router->url('winter:post', [
                'slug' => $this->slug,
            ]);
        }
    }

    public function __toString()
    {
        return (string) $this->title;
    }
}