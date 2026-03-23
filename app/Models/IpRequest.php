<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpRequest extends Model
{
    protected $table = 'ip_requests';

    protected $fillable = [
        'ip',
        'rir',
        'company_name',
        'company_domain',
        'abuse_score',
        'lat',
        'lon',
        'country',
        'zipcode',
        'type'
    ];
}
