<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dekan extends Model
{
    protected $table = 'dekan';
    
    protected $fillable = [
    'user_id',
    'prodi_id',
    'nuptk',
    'nama'
     ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
