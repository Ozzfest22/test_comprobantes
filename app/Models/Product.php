<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        'id',
        'cod_prod',
        'name',
        'description',
        'price'
    ];

    public function vouchers(){
        return $this->belongsToMany(Voucher::class, 'voucher_detail', 'id_prod', 'id_voucher')
            ->withPivot('quantity','price');
    }
}
