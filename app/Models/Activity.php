<?php


namespace App\Models;

class Activity extends AbstractModel
{
    protected $table = 'activity';

    protected $fillable = [
        'name',
        'description',
    ];
}