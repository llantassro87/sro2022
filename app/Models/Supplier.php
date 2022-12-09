<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Supplier extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['name', 'phone', 'contactname', 'contactphone', 'address', 'description'];

    public function purchase() {

        return $this->belongsTo(Purchase::class);

    }

}
