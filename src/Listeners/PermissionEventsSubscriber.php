<?php

namespace AMGPortal\UserActivity\Listeners;

use AMGPortal\Events\Permission\Created;
use AMGPortal\Events\Permission\Deleted;
use AMGPortal\Events\Permission\Updated;
use AMGPortal\UserActivity\Logger;

class PermissionEventsSubscriber
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
        $permission = $event->getPermission();

        $name = $permission->display_name ?: $permission->name;
        $message = trans('user-activity::log.new_permission', ['name' => $name]);

        $this->logger->log($message);
    }

    public function onUpdate(Updated $event)
    {
        $permission = $event->getPermission();

        $name = $permission->display_name ?: $permission->name;
        $message = trans('user-activity::log.updated_permission', ['name' => $name]);

        $this->logger->log($message);
    }

    public function onDelete(Deleted $event)
    {
        $permission = $event->getPermission();

        $name = $permission->display_name ?: $permission->name;
        $message = trans('user-activity::log.deleted_permission', ['name' => $name]);

        $this->logger->log($message);
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
    }
}
