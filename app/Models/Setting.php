<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Setting extends Model
{
    use Sluggable;
    use \App\Traits\Auditable;
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate'=>false
            ]
        ];
    }

}
