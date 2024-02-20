<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contestant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contestant';
    protected $fillable = ['name', 'email', 'phone','status'];
    public function media()
    {
        return $this->hasOne(Media::class, 'modul_id', 'id')->where('modul_type','=', 'yarisma');
    }
}
