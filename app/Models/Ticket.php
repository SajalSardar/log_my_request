<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget("ticket_list");
        });

        static::updated(function () {
            Cache::forget("ticket_list");
        });
    }

    /**
     * Define public method team() associate with Ticket
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    /**
     * Define public method category() associate with Ticket
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Define public method team() associate with Ticket
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Define public method ticket_status() associate with Ticket
     * @return BelongsTo
     */
    public function ticket_status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'ticket_status_id', 'id');
    }

    /**
     * Define public method requester_type() associate with Ticket
     * @return BelongsTo
     */
    public function requester_type(): BelongsTo
    {
        return $this->belongsTo(RequesterType::class, 'requester_type_id', 'id');
    }

    /**
     * Define public method requester_type() associate with Ticket
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }

    /**
     * Define public method image()
     * @return MorphTo
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'image', 'image_type', 'image_id');
    }

    public function owner()
    {
        return $this->belongsToMany(User::class, 'ticket_ownerships', 'ticket_id', 'owner_id');
    }
}
