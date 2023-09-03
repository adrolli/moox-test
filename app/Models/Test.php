<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'data',
        'nullable_longtext',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'data' => 'array',
    ];
}
