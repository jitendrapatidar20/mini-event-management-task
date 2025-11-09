<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class PageTitle extends Model
{
 	use Sluggable;
    use \App\Traits\Auditable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'page_title'
            ]
        ];
    }
}
