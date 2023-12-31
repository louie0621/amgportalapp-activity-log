<?php

namespace AMGPortal\UserActivity\Tests\Unit\Listeners;

use Mockery as m;
use AMGPortal\Events\Permission\Created;
use AMGPortal\Events\Permission\Deleted;
use AMGPortal\Events\Permission\Updated;
use \AMGPortal\UserActivity\Tests\Unit\Listeners\ListenerTestCase;

class PermissionEventsSubscriberTest extends ListenerTestCase
{
    protected $perm;

    protected function setUp(): void
    {
        parent::setUp();
        $this->perm = factory(\AMGPortal\Permission::class)->create();
    }

    /** @test */
    public function onCreate()
    {
        event(new Created($this->perm));
        $this->assertMessageLogged("Created new permission called {$this->perm->display_name}.");
    }

    /** @test */
    public function onUpdate()
    {
        event(new Updated($this->perm));
        $this->assertMessageLogged("Updated the permission named {$this->perm->display_name}.");
    }

    /** @test */
    public function onDelete()
    {
        event(new Deleted($this->perm));
        $this->assertMessageLogged("Deleted permission named {$this->perm->display_name}.");
    }
}
