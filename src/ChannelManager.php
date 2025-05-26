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

use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\Event\EventDispatcher;
use Vhunakoshi\Notifications\Channels\MailChannel;
use Vhunakoshi\Notifications\Contracts\ChannelInterface;
use Vhunakoshi\Notifications\Contracts\ChannelManagerInterface;
use Vhunakoshi\Notifications\Contracts\Notification;
use Vhunakoshi\Notifications\Contracts\NotificationDispatcherInterface;
use Psr\Container\ContainerInterface;

class ChannelManager implements NotificationDispatcherInterface, ChannelManagerInterface
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * @var \Vhunakoshi\Notifications\Contracts\ChannelInterface[]
     */
    protected $channels = [];

    /**
     * The default channel used to deliver messages.
     *
     * @var string
     */
    protected $defaultChannel = MailChannel::class;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function send($notifiables, Notification $notification): void
    {
        (new NotificationSender(
            $this,
            $this->container->get(EventDispatcher::class),
            $this->container->get(DriverFactory::class)
        ))->send($notifiables, $notification);
    }

    public function sendNow($notifiables, Notification $notification, ?array $channels = null): void
    {
        (new NotificationSender(
            $this,
            $this->container->get(EventDispatcher::class),
            $this->container->get(DriverFactory::class)
        ))->sendNow($notifiables, $notification, $channels);
    }

    /**
     * Get a channel instance.
     */
    public function channel(?string $driver = null): ChannelInterface
    {
        return $this->get($driver);
    }

    /**
     * Get a channel instance.
     */
    public function get(?string $driver = null): ChannelInterface
    {
        $driver = $driver ?: $this->getDefaultDriver();
        return $this->channels[$driver] ?? ($this->channels[$driver] = $this->createChannel($driver));
    }

    /**
     * Get the default channel driver name.
     */
    public function getDefaultDriver(): string
    {
        return $this->defaultChannel;
    }

    /**
     * Get the default channel driver name.
     */
    public function deliversVia(): string
    {
        return $this->getDefaultDriver();
    }

    /**
     * Set the default channel driver name.
     */
    public function deliverVia(string $channel)
    {
        $this->defaultChannel = $channel;
    }

    /**
     * Set the locale of notifications.
     */
    public function locale(string $locale): PendingNotification
    {
        return (new PendingNotification($this))->locale($locale);
    }

    /**
     * Create a new driver instance.
     */
    protected function createChannel(string $driver): ChannelInterface
    {
        return make($driver);
    }
}
