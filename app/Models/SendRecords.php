<?php


namespace App\Models;


class SendRecords extends AbstractModel
{
    protected $table = 'send_records';

    protected $fillable = [
        'mobile',
        'code'
    ];
}