<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CodeSecret extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'codecypte',
        'dure',
        'user_id',
    ];
   

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
