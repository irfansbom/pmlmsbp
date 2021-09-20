<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $table = 'm_dsbs';
    protected $fillable = ['nks', 'dok_diterima', 'dok_diserahkan', 'deskripsi'];
}
