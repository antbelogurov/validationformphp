<?php 

$examples = [
    'name' => [
        'innerName' => 'Имя',
        'required' => true
    ],
    'email' => [
        'innerName' => 'Почта',
        'required' => true
    ],
    'password' => [
        'innerName' => 'Пароль',
        'required' => true
    ],
    'phone' => [
        'innerName' => 'Телефон',
        'required' => true
    ],
    'adress' => [
        'innerName' => 'Адрес',
        'required' => false
    ],
    'comment' => [
        'innerName' => 'Комментарий',
        'required' => false
    ],
    'check' => [
        'innerName' => 'Согласие на обработку',
        'required' => true,
        'mailable' => 0,
    ],
    'capcha' => [
        'innerName' => 'Капча',
        'required' => true,
        'mailable' => 0,
    ],
];

$mailSettings = [
    'host' => 'smtp.mailtrap.io',
    'smtp_auth' => true,
    'username' => '98bf4470f12550',
    'password' => 'f829fa3a02ae4',
    'smtp_secure' => null,
    'port' => 2525,
    'from_email' => '5dfd3f49b5-3fca52@inbox.mailtrap.io',
    'from_name' => 'My Site',
    'to_email' => 'user@mail.com'
];
