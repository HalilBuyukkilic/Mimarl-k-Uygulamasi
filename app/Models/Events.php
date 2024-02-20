<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'events';

    // protected $fillable = [
    //     'title',
    //     'summary',
    //     'content',
    //     'status',
    //     'start_date',
    //     'end_date',
    // ];

    public function media()
    {
        return $this->hasMany(Media::class, 'modul_id', 'id')->where('modul_type','=', 'etkinlik');
    }

    public function mediaOne()
    {
        return $this->hasOne(Media::class, 'modul_id', 'id')->where('modul_type','=', 'etkinlik');
    }
}
