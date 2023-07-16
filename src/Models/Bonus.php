<?php

namespace Sashagm\Money\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'summa',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
