<?php
namespace Modules\Winter\Models;

use Cocur\Slugify\Slugify;
use Phact\Orm\Fields\BooleanField;
use Phact\Orm\Fields\CharField;
use Phact\Orm\Fields\DateTimeField;
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
            'is_draft' => [
                'label' => self::t('Winter', 'Is draft'),
                'class' => BooleanField::class,
                'null' => true,
                'default' => true,
            ],
        ];
    }

    private function makeIntroduction()
    {
        if ($this->introduction == "") {
            $text = '';
            foreach ($this->content as $item) {
                if ($item['type'] != 'text') continue;
                $text .= strip_tags($item['data']);
            }

            foreach (explode(' ', $text) as $word) {
                if (mb_strlen($this->introduction) > 512) break;
                $this->introduction .= "$word ";
            }
        }
    }

    private function uniqueSlug()
    {
        if ($this->slug == "") {
            $sf = new Slugify();
            $this->slug = mb_substr($sf->slugify($this->title), 0, 225);
        }

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

        if (!$this->is_draft) {
            $this->uniqueSlug();
            $this->makeIntroduction();
        }

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

    public function __toString()
    {
        return (string) $this->title;
    }
}