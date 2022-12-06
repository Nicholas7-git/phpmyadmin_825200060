<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class RekeningModel extends Model
{
    protected $table = 'rekening';
    protected $primaryKey = 'id';
    protected $allowedFields = ['MerchantName','NoRekening','NamaRekening','SaldoRekening'];
}