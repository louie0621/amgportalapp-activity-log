<?php

namespace AMGPortal\UserActivity\Listeners;

use AMGPortal\Events\Role\Created;
use AMGPortal\Events\Role\PermissionsUpdated;
use AMGPortal\Events\Role\Updated;
use AMGPortal\Events\Role\Deleted;
use AMGPortal\UserActivity\Logger;

class RoleEventsSubscriber
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function onCreate(Created $event)
    {
        $message = trans(
            'user-activity::log.new_role',
            ['name' => $event->getRole()->display_name]
        );

        $this->logger->log($message);
    }

    public function onUpdate(Updated $event)
    {
        $message = trans(
            'user-activity::log.updated_role',
            ['name' => $event->getRole()->display_name]
        );

        $this->logger->log($message);
    }

    public function onDelete(Deleted $event)
    {
        $message = trans(
            'user-activity::log.deleted_role',
            ['name' => $event->getRole()->display_name]
        );

        $this->logger->log($message);
    }

    public function onPermissionsUpdate(PermissionsUpdated $event)
    {
        $this->logger->log(trans('user-activity::log.updated_role_permissions'));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $class = self::class;

        $events->listen(Created::class, "{$class}@onCreate");
        $events->listen(Updated::class, "{$class}@onUpdate");
        $events->listen(Deleted::class, "{$class}@onDelete");
        $events->listen(PermissionsUpdated::class, "{$class}@onPermissionsUpdate");
    }
}
