<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    use HasFactory;

    const GENDER_MALE = 'Laki-laki';
    const GENDER_FEMALE = 'Perempuan';

    protected $fillable = [
        'name',
        'gender',
        'phone',
        'address',
        'date_of_birth',
        'agency'
    ];

    public static function genderOptions()
    {
        return [
            self::GENDER_MALE => 'Laki-laki',
            self::GENDER_FEMALE => 'Perempuan',
        ];
    }

    public function activity()
    {
        return $this->hasMany(ReadingActivity::class);
    }
}
