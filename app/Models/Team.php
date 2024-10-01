<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget("team_list");
        });

        static::updated(function () {
            Cache::forget("team_list");
        });
    }

    public function teamCategories()
    {
        return $this->belongsToMany(Category::class, 'team_categories');
    }

    /**
     * Define public method image()
     * @return MorphTo
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'image', 'image_type', 'image_id');
    }

    public function agents()
    {
        return $this->belongsToMany(User::class);
    }
}
