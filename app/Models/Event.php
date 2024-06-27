<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "description",
        "slug",
        "image",
        "start_date",
        "end_date",
        "meeting_room_id"
    ];


    public function type(): BelongsTo{
        return $this->belongsTo(MeetingRoom::class);

    }
}