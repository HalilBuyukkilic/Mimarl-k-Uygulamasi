<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Media;

class Receipts extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'receipts';

    public function user()
    {
        return $this->hasOne(User::class, 'id','author');
    }
    
    public function media()
    {
        return $this->hasOne(Media::class, 'modul_id', 'id')->where('modul_type','=', 'dekont');
    }
}
