<?php

declare(strict_types=1);
/**
 * This file is part of hyperf-ext/notifications.
 *
 * @link     https://github.com/vhunakoshi/hyperf-ext-notifications
 * @contact  eric@zhu.email
 * @license  https://github.com/vhunakoshi/hyperf-ext-notifications/blob/master/LICENSE
 */
namespace Vhunakoshi\Notifications\Channels;

use Vhunakoshi\Mail\Contracts\MailManagerInterface;
use Vhunakoshi\Notifications\Contracts\ChannelInterface;
use Vhunakoshi\Notifications\Contracts\Notification;
use Vhunakoshi\Notifications\Messages\MailMessage;

class MailChannel implements ChannelInterface
{
    /**
     * The mailer implementation.
     *
     * @var \Vhunakoshi\Mail\Contracts\MailManagerInterface
     */
    protected $mailer;

    /**
     * Create a new mail channel instance.
     */
    public function __construct(MailManagerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @return mixed|void
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var \Vhunakoshi\Mail\Mailable $message */
        $message = $notification->toMail($notifiable);

        if (empty($recipients = $notifiable->routeNotificationFor(static::class, $notification)) && ! $message instanceof MailMessage) {
            return;
        }

        $message->to($recipients);

        return $message->send($this->mailer);
    }
}
