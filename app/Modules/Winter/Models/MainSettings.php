<?php
namespace Modules\Winter\Models;

use Phact\Orm\Model;

class MainSettings extends Model
{
    public static function getFields()
    {
        return [
//            'email' => [
//                'null' => true,
//                'class' => CharField::class,
//                'label' => 'Email'
//            ],
        ];
    }

    public function __toString()
    {
        return 'Settings';
    }
} 