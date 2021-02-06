<?php


namespace App\Models;


use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}