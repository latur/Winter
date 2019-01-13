<?php

namespace Modules\Winter\Forms;

use Modules\Winter\Models\Settings;
use Phact\Form\ModelForm;
use Phact\Form\Fields\CharField;
use Phact\Translate\Translator;

class SettingsForm extends ModelForm
{
    use Translator;

    public function getFields()
    {
        return [
            'site' => [
                'class' => CharField::class,
                'label' => self::t('Winter', 'Site name'),
                'attributes' => [
                    'class' => 'form-control'
                ],
            ],
            'slogan' => [
                'class' => CharField::class,
                'label' => self::t('Winter', 'Site slogan'),
                'attributes' => [
                    'class' => 'form-control'
                ],
            ],
        ];
    }

    public function getModel()
    {
        $model = Settings::objects()->get();
        return $model ? $model : new Settings;
    }
}
