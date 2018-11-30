<?php
namespace Modules\Winter\Models;

use Phact\Orm\Fields\CharField;
use Phact\Orm\Fields\FileField;
use Phact\Orm\Model;
use Phact\Storage\Files\UploadedFile;
use Phact\Translate\Translator;

class Attachment extends Model
{
    use Translator;

    public static function getFields()
    {
        return [
            'code' => [
                'label' => self::t('Winter', 'Secure code'),
                'class' => CharField::class,
            ],
            'name' => [
                'null' => true,
                'label' => self::t('Winter', 'File name'),
                'class' => CharField::class,
            ],
            'file' => [
                'label' => self::t('Winter', 'Attachment'),
                'class' => FileField::class,
            ],
        ];
    }

    public function loader($file)
    {
        if (!is_array($file) || !array_key_exists('error', $file)) return [
            'error' => 'File not found'
        ];

        if ($file['error'] !== 0) return [
            'error' => 'Loading error: ' . (int) $file['error']
        ];

        $this->code = sha1(random_bytes(100) . uniqid());
        $this->name = mb_substr($file['name'], 0, 255);

        $file['name'] = sha1(random_bytes(100) . uniqid()) . '.dump';
        $this->file = new UploadedFile($file);
        $this->save();

        return [ 'code' => $this->code ];
    }

    public function __toString()
    {
        return "Attachment";
    }
}
