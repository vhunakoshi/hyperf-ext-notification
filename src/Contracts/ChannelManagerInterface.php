<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-ext/notifications.
 *
 * @link     https://github.com/vhunakoshi/hyperf-ext-notifications
 * @contact  eric@zhu.email
 * @license  https://github.com/vhunakoshi/hyperf-ext-notifications/blob/master/LICENSE
 */
namespace Vhunakoshi\Notifications\Contracts;

interface ChannelManagerInterface
{
    /**
     * Get a channel instance by name.
     *
     * @return mixed
     */
    public function channel(?string $name = null);

    /**
     * Send the given notification to the given notifiable entities.
     *
     * @param array|\Hyperf\Utils\Collection|mixed $notifiables
     */
    public function send($notifiables, Notification $notification): void;

    /**
     * Send the given notification immediately.
     *
     * @param array|\Hyperf\Utils\Collection|mixed $notifiables
     */
    public function sendNow($notifiables, Notification $notification): void;
}
