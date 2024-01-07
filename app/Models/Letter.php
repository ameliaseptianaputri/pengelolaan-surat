<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_type_id',
        'letter_perihal',
        'recipients',
        'content',
        'attachment',
        'notulis',
    ];

    protected $casts = [
        'recipients' => 'array'
    ];

    /**
     * Get all of the Letter for the Letter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function LetterType(): HasMany
    // {
    //     return $this->hasMany(Letter::class);
    // }

    /**
     * Get the user that owns the Letter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    //ke user mengambil nama notulis
    public function user()
    {
        return $this->belongsTo(User::class, 'notulis', 'id');
    }

    //ke lettertype ngambil kode surat letter_code
    public function letterType(){
        return $this->belongsTo(LetterType::class,'letter_type_id', 'id');
    }

    public function result() {
        return $this->hasMany(Result::class, 'letter_id', 'id');
    }
}