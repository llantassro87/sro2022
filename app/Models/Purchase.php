<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Purchase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['quantity', 'total', 'supplier_id', 'product_id', 'user_id'];

    public function products() {

        return $this->hasMany(Product::class);
    }

    public function supplier() {

        return $this->hasMany(Supplier::class);
    }
}
