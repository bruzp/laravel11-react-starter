<?php

namespace App\Models;

use App\Helpers\Common\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAnswerRanking extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $appends = ['rank_text'];

    protected function rankText(): Attribute
    {
        return Attribute::make(
            get: fn() => Helper::ordinal($this->rank_no),
        );
    }

}
