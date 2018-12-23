<?php

namespace Modules\Winter\Forms;

use Phact\Form\Fields\CharField;
use Phact\Form\Fields\PasswordField;
use Phact\Form\Form;
use Phact\Interfaces\AuthInterface;
use Phact\Translate\Translator;

class LoginForm extends Form
{
    use Translator;

    /** @var AuthInterface */
    protected $_auth;

    public function __construct(array $config = [], AuthInterface $auth)
    {
        parent::__construct($config);
        $this->_auth = $auth;
    }

    public function getFields()
    {
        return [
            'username' => [
                'class' => CharField::class,
                'label' => self::t('Winter', 'Username'),
                'attributes' => [
                    'class' => 'form-control'
                ],
                'required' => true
            ],
            'password' => [
                'class' => PasswordField::class,
                'label' => self::t('Admin', 'Password'),
                'attributes' => [
                    'class' => 'form-control'
                ],
                'required' => true
            ]
        ];
    }

    public function clean($attributes)
    {
        $user = $this->_auth->findUserByLogin($attributes['username']);
        if (!$user || !$this->_auth->verifyPassword($user, $attributes['password'])) {
            $this->addError('password', self::t('Manage', 'Incorrect password'));
        }
    }

    public function login()
    {
        $data = $this->getAttributes();
        $user = $this->getUser($data['username']);
        if ($user) {
            $this->_auth->login($user);
        }
    }

    public function getUser($email)
    {
        return $this->_auth->findUserByLogin($email);
    }
}