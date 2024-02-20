<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Competition extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'competition';

    public function media()
    {
        return $this->hasMany(Media::class, 'modul_id', 'id')->where('modul_type','=', 'yarisma');
    }
    
    public function mediaOne()
    {
        return $this->hasOne(Media::class, 'modul_id', 'id')->where('modul_type','=', 'yarisma');
    }


    


}
