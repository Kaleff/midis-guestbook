<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'text',
        'ip_address',
    ];

     /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['editable'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['ip_address', 'email'];

    /**
     * Determine if the post is editable.
     * A post is considered editable if:
     * 1. It was created by the same IP address as the current request
     * 2. It is less than or equal to 5 minutes old
     */
    protected function editable(): Attribute
    {
        return Attribute::make(
            get: function () {
                $currentIp = Request::ip();
                $createdAt = $this->created_at;
                $ageInMinutes = $createdAt->diffInMinutes(now());

                return ($this->ip_address === $currentIp && $ageInMinutes <= 5);
            }
        );
    }
}
