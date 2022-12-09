<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Denomination extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['type', 'value', 'image'];

    public function getImagenAttribute($image)
    {
        if ($this->image != NULL) {
            return (file_exists('storage/denominations/' . $this->image) ? $this->image : 'noimg.jpg');
        } else {
            return 'noimg.jpg';
        }
    }

}
