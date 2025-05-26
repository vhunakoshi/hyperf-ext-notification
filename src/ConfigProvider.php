<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-ext/notifications.
 *
 * @link     https://github.com/vhunakoshi/hyperf-ext-notifications
 * @contact  eric@zhu.email
 * @license  https://github.com/vhunakoshi/hyperf-ext-notifications/blob/master/LICENSE
 */
namespace Vhunakoshi\Notifications;

use Vhunakoshi\Notifications\Commands\GenNotificationCommand;
use Vhunakoshi\Notifications\Commands\NotificationTableCommand;
use Vhunakoshi\Notifications\Contracts\NotificationDispatcherInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                NotificationDispatcherInterface::class => ChannelManager::class,
            ],
            'commands' => [
                NotificationTableCommand::class,
                GenNotificationCommand::class,
            ],
        ];
    }
}
