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
        "color",
        "start_date",
        "end_date",
        "meeting_room_id"
    ];


    public function meetingroom(): BelongsTo{
        return $this->belongsTo(MeetingRoom::class,'meeting_room_id');

    }
}
