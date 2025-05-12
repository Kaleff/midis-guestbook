<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

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
        'image',
    ];

     /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['editable', 'image_url'];

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

    /**
     * Get the URL for the post's image.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->image) {
                    return asset(Storage::url($this->image));
                }
                return null;
            }
        );
    }
}
