<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-ext/notifications.
 *
 * @link     https://github.com/vhunakoshi/hyperf-ext-notifications
 * @contact  eric@zhu.email
 * @license  https://github.com/vhunakoshi/hyperf-ext-notifications/blob/master/LICENSE
 */
namespace Vhunakoshi\Notifications\Commands;

use Hyperf\Devtool\Generator\GeneratorCommand;

class GenNotificationCommand extends GeneratorCommand
{
    public function __construct()
    {
        parent::__construct('gen:notification');
        $this->setDescription('Create a new notification class');
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return __DIR__ . '/stubs/notification.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(): string
    {
        return $this->getConfig()['namespace'] ?? 'App\\Notification';
    }
}
