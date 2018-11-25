<?php
namespace Modules\Winter\Models;

use Phact\Orm\Fields\CharField;
use Phact\Orm\Model;
use Phact\Orm\Fields\ImageField;
use Phact\Storage\Files\ResourceFile;
use Phact\Translate\Translator;

class Media extends Model
{
    use Translator;

    public static function getSizes()
    {
        return [
            'mini' => [30, 30, 'method' => 'contain'],
            'small' => [200, 200, 'method' => 'contain'],
            'medium' => [450, 450, 'method' => 'contain'],
            'large' => [860, 860, 'method' => 'contain'],
            'xlarge' => [1600, 1600, 'method' => 'contain'],
        ];
    }

    public static function getFields()
    {
        return [
            'code' => [
                'label' => self::t('Winter', 'Secure code'),
                'class' => CharField::class,
            ],
            'image' => [
                'label' => self::t('Winter', 'Post image'),
                'class' => ImageField::class,
                'sizes' => self::getSizes(),
            ],
        ];
    }

    public function decode($base64url)
    {
        $exts = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
        ];

        $info = explode(';base64,', $base64url);
        if (count($info) != 2) return [
            'error' => self::t('Winter', 'Wrong base64 image code')
        ];

        $type = substr($info[0], strlen("data:"));
        if (!array_key_exists($type, $exts)) return [
            'error' => self::t('Winter', 'Wrong image type')
        ];

        $name = base_convert(uniqid(), 10, 32) . ".". $exts[$type];
        $this->image = new ResourceFile(base64_decode($info[1]), $name);
        $this->code = sha1(random_bytes(100) . uniqid());
        $this->save();

        return ['url' => $this->image->url, 'code' => $this->code];
    }

    public function __toString()
    {
        return "Blog image";
    }
}