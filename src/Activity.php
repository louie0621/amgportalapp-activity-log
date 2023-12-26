<?php

namespace AMGPortal\UserActivity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AMGPortal\User;
use Illuminate\Database\Eloquent\Model;
use AMGPortal\UserActivity\Database\Factories\ActivityFactory;

class Activity extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $table = 'user_activity';

    protected $fillable = ['description', 'user_id', 'ip_address', 'user_agent'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new ActivityFactory;
    }
}
