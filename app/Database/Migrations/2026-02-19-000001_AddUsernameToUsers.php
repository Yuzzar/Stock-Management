<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsernameToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'name',
            ],
        ]);

        $this->forge->addUniqueKey('username', 'username');
        $this->forge->processIndexes('users');
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'username');
    }
}
