<?php
namespace App\Models\v1;

use CodeIgniter\Model;

class ClientModel extends Model {
    
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'logo', 'address', 'phone', 'email', 'status', 'fee_payment', 'settings'];
}
?>