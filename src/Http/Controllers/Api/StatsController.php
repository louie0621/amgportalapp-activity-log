<?php

namespace AMGPortal\UserActivity\Http\Controllers\Api;

use Auth;
use Carbon\Carbon;
use AMGPortal\Http\Controllers\Api\ApiController;
use AMGPortal\UserActivity\Repositories\Activity\ActivityRepository;

/**
 * Class ActivityController
 * @package AMGPortal\Http\Controllers\Api\Users
 */
class StatsController extends ApiController
{
    /**
     * @var ActivityRepository
     */
    private $activities;

    public function __construct(ActivityRepository $activities)
    {
        $this->middleware('auth');

        $this->activities = $activities;
    }

    /**
     * Get activities for specified user.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return $this->activities->userActivityForPeriod(
            Auth::user()->id,
            Carbon::now()->subWeeks(2),
            Carbon::now()
        );
    }
}
