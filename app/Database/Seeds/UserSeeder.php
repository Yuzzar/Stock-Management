<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'       => 'Administrator',
                'username'   => 'admin',
                'email'      => 'admin@tokoku.id',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'role'       => 'admin',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Kasir Satu',
                'username'   => 'kasir',
                'email'      => 'kasir@tokoku.id',
                'password'   => password_hash('kasir123', PASSWORD_BCRYPT),
                'role'       => 'kasir',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($users as $user) {
            $exists = $this->db->table('users')->where('email', $user['email'])->countAllResults();
            if ($exists) {
                $this->db->table('users')->where('email', $user['email'])->update([
                    'username' => $user['username'],
                ]);
            } else {
                $this->db->table('users')->insert($user);
            }
        }
    }
}
