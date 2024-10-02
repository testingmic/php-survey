<?php
namespace App\Models\v1;

use CodeIgniter\Model;

class AuthModel extends Model {
    
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password', 'username', 'group_id', 'client_id'];
}
?>