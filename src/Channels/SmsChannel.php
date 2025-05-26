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

use Vhunakoshi\Notifications\Contracts\ChannelInterface;
use Vhunakoshi\Notifications\Contracts\Notification;
use Vhunakoshi\Notifications\Messages\SmsMessage;
use Vhunakoshi\Sms\Contracts\MobileNumberInterface;
use Vhunakoshi\Sms\Contracts\SmsManagerInterface;
use LogicException;

class SmsChannel implements ChannelInterface
{
    /**
     * The mailer implementation.
     *
     * @var \Vhunakoshi\Sms\Contracts\SmsManagerInterface
     */
    protected $smsManager;

    /**
     * Create a new mail channel instance.
     */
    public function __construct(SmsManagerInterface $smsManager)
    {
        $this->smsManager = $smsManager;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @return mixed|void
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var \Vhunakoshi\Sms\Contracts\SmsMessageInterface $message */
        $message = $notification->toSms($notifiable);

        if (empty($recipient = $notifiable->routeNotificationFor(static::class, $notification)) && ! $message instanceof SmsMessage) {
            return;
        }

        if (! $recipient instanceof MobileNumberInterface) {
            throw new LogicException('The SMS recipient must be instance of ' . MobileNumberInterface::class);
        }

        $message->to($recipient);

        return $this->smsManager->send($message);
    }
}
