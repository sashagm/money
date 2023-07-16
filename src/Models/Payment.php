<?php

namespace Sashagm\Money\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'desc',
        'summa',
        'bonus',
        'initid',
        'provider',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
