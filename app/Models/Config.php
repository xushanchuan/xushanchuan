<?php


namespace App\Models;

class Config extends AbstractModel
{
    protected $table = 'config';

    protected $fillable = [
        'name',
        'description',
    ];
}