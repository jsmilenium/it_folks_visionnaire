<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'document_type',
        'version',
        'columns_and_fields',
    ];

    public function values()
    {
        return $this->hasMany(DocumentValue::class);
    }
}
