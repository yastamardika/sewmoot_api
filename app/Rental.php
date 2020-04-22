<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';

    protected $fillable = ['nama_rental', 'owner', 'alamat','nomorhp','email','map'];

}
