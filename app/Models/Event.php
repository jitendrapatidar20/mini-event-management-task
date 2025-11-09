<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Event extends Model
{
 	use Sluggable;
    use \App\Traits\Auditable;
    
    protected $fillable = [
        'title',
        'start_time',
        'end_time',
        'location',
        'total_seats',
        'available_seats',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function bookings() {
      return $this->hasMany(Booking::class);
    }
}
