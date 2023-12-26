<?php

namespace AMGPortal\UserActivity\Http\View\Composers;

use Illuminate\View\View;
use AMGPortal\UserActivity\Repositories\Activity\ActivityRepository;

class ShowUserComposer
{
    /**
     * @var ActivityRepository
     */
    private $activity;

    public function __construct(ActivityRepository $activity)
    {
        $this->activity = $activity;
    }

    public function compose(View $view)
    {
        $user = $view->getData()['user'];

        $view->with('activities', $this->activity->getLatestActivitiesForUser($user->id));
    }
}
