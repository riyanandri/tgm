<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReadingActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'reader_id',
        'book_id',
        'reading_date',
        'reading_duration'
    ];

    public function reader()
    {
        return $this->belongsTo(Reader::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
