<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-ext/notifications.
 *
 * @link     https://github.com/vhunakoshi/hyperf-ext-notifications
 * @contact  eric@zhu.email
 * @license  https://github.com/vhunakoshi/hyperf-ext-notifications/blob/master/LICENSE
 */
namespace Vhunakoshi\Notifications\Events;

use Vhunakoshi\Notifications\Contracts\Notification;

class NotificationFailed
{
    /**
     * The notifiable entity who received the notification.
     *
     * @var mixed
     */
    public $notifiable;

    /**
     * The notification instance.
     *
     * @var \Vhunakoshi\Notifications\Notification
     */
    public $notification;

    /**
     * The channel class.
     *
     * @var string
     */
    public $channel;

    /**
     * The data needed to process this failure.
     *
     * @var array
     */
    public $data = [];

    /**
     * Create a new event instance.
     *
     * @param mixed $notifiable
     */
    public function __construct($notifiable, Notification $notification, string $channel, array $data = [])
    {
        $this->data = $data;
        $this->channel = $channel;
        $this->notifiable = $notifiable;
        $this->notification = $notification;
    }
}
