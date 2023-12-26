<?php

namespace AMGPortal\UserActivity\Http\Controllers\Api;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use AMGPortal\UserActivity\Http\Resources\ActivityResource;
use AMGPortal\UserActivity\Activity;
use AMGPortal\UserActivity\Http\Requests\GetActivitiesRequest;
use AMGPortal\Http\Controllers\Api\ApiController;

/**
 * Class ActivityController
 * @package AMGPortal\Http\Controllers\Api
 */
class ActivityController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users.activity');
    }

    /**
     * Paginate user activities.
     * @param GetActivitiesRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(GetActivitiesRequest $request)
    {
        $activities = QueryBuilder::for(Activity::class)
            ->allowedIncludes('user')
            ->allowedFilters([
                AllowedFilter::partial('description'),
                AllowedFilter::exact('user', 'user_id')
            ])
            ->allowedSorts('created_at')
            ->defaultSort('-created_at')
            ->paginate($request->per_page ?: 20);

        return ActivityResource::collection($activities);
    }
}
