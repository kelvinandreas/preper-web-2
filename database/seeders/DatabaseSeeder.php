<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed the MsRole table
        DB::table('msrole')->insert([
            ['RoleId' => 1, 'RoleName' => 'Mentee'],
            ['RoleId' => 2, 'RoleName' => 'Mentor'],
            ['RoleId' => 3, 'RoleName' => 'Verificator'],
        ]);

        // Seed the MsUserRank table
        DB::table('msuserrank')->insert([
            ['UserRankId' => 1, 'UserRankName' => 'Warrior'],
            ['UserRankId' => 2, 'UserRankName' => 'Elite'],
            ['UserRankId' => 3, 'UserRankName' => 'Master'],
            ['UserRankId' => 4, 'UserRankName' => 'GrandMaster'],
            ['UserRankId' => 5, 'UserRankName' => 'Epic'],
            ['UserRankId' => 6, 'UserRankName' => 'Legend'],
            ['UserRankId' => 7, 'UserRankName' => 'Mythic'],
            ['UserRankId' => 8, 'UserRankName' => 'Glorious Mythic'],
        ]);

        // Seed the MsSubject table
        DB::table('mssubject')->insert([
            ['SubjectId' => 1, 'SubjectName' => 'Kemampuan Penalaran Umum'],
            ['SubjectId' => 2, 'SubjectName' => 'Pengetahuan dan Pemahaman Umum'],
            ['SubjectId' => 3, 'SubjectName' => 'Kemampuan Memahami Bacaan dan Menulis'],
            ['SubjectId' => 4, 'SubjectName' => 'Pengetahuan Kuantitatif'],
            ['SubjectId' => 5, 'SubjectName' => 'Literasi dalam Bahasa Indonesia'],
            ['SubjectId' => 6, 'SubjectName' => 'Literasi dalam Bahasa Inggris'],
            ['SubjectId' => 7, 'SubjectName' => 'Penalaran Matematika'],
        ]);
    }
}
