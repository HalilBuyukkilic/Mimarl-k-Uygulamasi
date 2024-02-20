<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompetitionDatas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'competition_datas';

    public function media()
    {
        return $this->hasOne(Media::class, 'modul_id', 'id')->where('modul_type','=', 'yarisma_katilim');
    }


    public function media_user()
    {
        return $this->hasMany(Media::class, 'modul_id','competition_id')->where('media_type','image')->where('modul_type', 'yarisma_katilim');
    }

    public function user_data()
    {
        return $this->hasOne(User::class,  'id','user_id');
    }

    public function media_contestant()
    {
        return $this->hasMany(Media::class, 'modul_id', 'competition_id')->where('media_type','image')->where('modul_type', 'yarisma_katilim');
    }

    public function contestant_data()
    {
        return $this->hasOne(Contestant::class, 'id','contestant_id');
    }

  
}
