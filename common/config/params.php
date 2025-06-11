<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'rabbitmq' => [
        'host' => $_ENV['RABBITMQ_HOST'],
        'port' => $_ENV['RABBITMQ_PORT'],
        'user' => $_ENV['RABBITMQ_USER'],
        'pass' => $_ENV['RABBITMQ_PASS'],
        'heartbeat' => $_ENV['RABBITMQ_HEARTBEAT'],
    ],
];
