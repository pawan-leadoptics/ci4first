<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "profile";
    protected $primaryKey = "UserID";
    protected $allowedFields = [
        'FirstName',
        'LastName',
        'Email',
        'MobileNumber',
        'Password',
        'Token',
        'Verified',
        'date_time',
        'Image'
    ];
    // public function saveToken($data)
    // { 
    //     $this->db->table('profile')->update($data);
    // }
    public function verificationStatus($data)
    {
        return $this->update($data[$this->primaryKey], ['Verified' => $data['Verified']]);
    }
    public function deleteUserByEmailInAuthPage($email)
    {
        return $this->db->table('profile')->where('Email', $email)->delete();
    }
}


