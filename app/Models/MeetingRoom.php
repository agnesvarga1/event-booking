<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
class MeetingRoom extends Model
{
    use HasFactory;

    use HasFactory;
    protected $fillable=[
         'name',
         'slug',
         'available_places',
         'decrption'
    ];

    public static function generateSlug($name)
    {
        return Str::slug($name, '-');
    }
    public function events(): HasMany{
        return $this->hasMany( Event::class);
    }
}
