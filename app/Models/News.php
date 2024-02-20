<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'news';

    public function media()
    {
        return $this->hasOne(Media::class, 'modul_id', 'id')->where('modul_type','=', 'haber');
    }
}
