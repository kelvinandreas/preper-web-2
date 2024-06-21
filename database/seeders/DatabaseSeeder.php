<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            ['RoleId' => 3, 'RoleName' => 'Admin'],
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
            ['SubjectId' => 1, 'SubjectName' => 'Pemrograman Dasar'],
            ['SubjectId' => 2, 'SubjectName' => 'Manajemen Waktu'],
            ['SubjectId' => 3, 'SubjectName' => 'Pengelolaan Keuangan Pribadi'],
            ['SubjectId' => 4, 'SubjectName' => 'Komunikasi Efektif'],
            ['SubjectId' => 5, 'SubjectName' => 'Pengenalan Digital Marketing'],
            ['SubjectId' => 6, 'SubjectName' => 'Dasar-dasar Fotografi'],
            ['SubjectId' => 7, 'SubjectName' => 'Desain Grafis'],
            ['SubjectId' => 8, 'SubjectName' => 'Penggunaan Microsoft Excel'],
            ['SubjectId' => 9, 'SubjectName' => 'Pemrograman Web'],
            ['SubjectId' => 10, 'SubjectName' => 'Ilustrasi'],
            ['SubjectId' => 11, 'SubjectName' => 'Manajemen Proyek'],
            ['SubjectId' => 12, 'SubjectName' => 'UX/UI Design'],
        ]);

        // Seed multiple users
        // Insert Mentee
        $mentees = [
            ['name' => 'Santi', 'phone' => '08123456789', 'email' => 'santi@gmail.com'],
            ['name' => 'Reza', 'phone' => '08127876543', 'email' => 'reza@gmail.com'],
            ['name' => 'Asep', 'phone' => '08123413535', 'email' => 'asep@gmail.com'],
            ['name' => 'Kiki', 'phone' => '08124567890', 'email' => 'kiki@gmail.com'],
            ['name' => 'Andi', 'phone' => '08125567890', 'email' => 'andi@gmail.com'],
        ];

        $userPoints = [100, 150, 200, 250, 300, 350, 400, 450, 500];

        $users = [];
        foreach ($mentees as $mentee) {
            $users[] = [
                'id' => Str::uuid()->toString(),
                'UserName' => $mentee['name'],
                'UserPhoneNumber' => $mentee['phone'],
                'email' => $mentee['email'],
                'password' => Hash::make('12312312'),
                'IsValid' => 0,
                'UserPoint' => $userPoints[array_rand($userPoints)],
                'RoleId' => 1,
                'SubjectId' => NULL,
                'UserRankId' => NULL,
            ];
        }

        DB::table('users')->insert($users);

        // Insert Mentor
        $mentors = [
            ['name' => 'Kelvin', 'phone' => '08121234567', 'email' => 'kelvin@gmail.com', 'subjectId' => 9],
            ['name' => 'Hendrik', 'phone' => '08127894563', 'email' => 'hendrik@gmail.com', 'subjectId' => 12],
            ['name' => 'Ivan', 'phone' => '08123456780', 'email' => 'ivan@gmail.com', 'subjectId' => 6],
            ['name' => 'Kevin', 'phone' => '08129871234', 'email' => 'kevin@gmail.com', 'subjectId' => 7],
            ['name' => 'Dimas', 'phone' => '08123451234', 'email' => 'dimas@gmail.com', 'subjectId' => 1],
        ];

        $users2 = [];
        foreach ($mentors as $mentor) {
            $users2[] = [
                'id' => Str::uuid()->toString(),
                'UserName' => $mentor['name'],
                'UserPhoneNumber' => $mentor['phone'],
                'email' => $mentor['email'],
                'password' => Hash::make('12312312'),
                'IsValid' => 0,
                'UserPoint' => $userPoints[array_rand($userPoints)],
                'RoleId' => 2,
                'SubjectId' => $mentor['subjectId'],
                'UserRankId' => NULL,
            ];
        }

        DB::table('users')->insert($users2);

        $menteeId = Str::uuid()->toString();
        $menteeId2 = Str::uuid()->toString();
        $menteeId3 = Str::uuid()->toString();
        $mentorId = Str::uuid()->toString();
        $adminId = Str::uuid()->toString();

        DB::table('users')->insert([
            [
                'id' => $menteeId,
                'UserName' => 'Siti',
                'UserPhoneNumber' => '08123513535',
                'email' => 'siti@gmail.com',
                'password' => Hash::make('12312312'),
                'IsValid' => 0,
                'UserPoint' => 100,
                'RoleId' => 1,
                'SubjectId' => NULL,
                'UserRankId' => NULL,
            ],
            [
                'id' => $menteeId2,
                'UserName' => 'Timothy',
                'UserPhoneNumber' => '0812345535',
                'email' => 'timothy@gmail.com',
                'password' => Hash::make('12312312'),
                'IsValid' => 0,
                'UserPoint' => 150,
                'RoleId' => 1,
                'SubjectId' => NULL,
                'UserRankId' => NULL,
            ],
            [
                'id' => $menteeId3,
                'UserName' => 'Dion',
                'UserPhoneNumber' => '0813243235',
                'email' => 'dion@gmail.com',
                'password' => Hash::make('12312312'),
                'IsValid' => 0,
                'UserPoint' => 200,
                'RoleId' => 1,
                'SubjectId' => NULL,
                'UserRankId' => NULL,
            ],
            [
                'id' => $mentorId,
                'UserName' => 'Budi',
                'UserPhoneNumber' => '08122346789',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('12312312'),
                'IsValid' => 1,
                'UserPoint' => 100,
                'RoleId' => 2,
                'SubjectId' => 1,
                'UserRankId' => NULL,
            ],
            [
                'id' => $adminId,
                'UserName' => 'Admin',
                'UserPhoneNumber' => '08129876543',
                'email' => 'admin@preper.com',
                'password' => Hash::make('12312312'),
                'IsValid' => 0,
                'UserPoint' => 0,
                'RoleId' => 3,
                'SubjectId' => NULL,
                'UserRankId' => NULL,
            ],
        ]);

        // Seed the TrMentoringSchedule table
        DB::table('trmentoringschedule')->insert([
            [
                'TrMentoringScheduleId' => Str::uuid()->toString(),
                'MenteeUserId' => $menteeId2,
                'MentorUserId' => $mentorId,
                'UniqueCode' => 'D1A2',
                'MeetingTime' => now()->addDay()->format('Y-m-d') . ' 17:20:00',
                'MeetingLink' => 'https://meet.google.com/Kia1NfQLB',
                'SubjectId' => 1,
                'SpecificTopic' => 'Belajar PHP',
                'IsDone' => 0,
                'MenteeReview' => null,
            ],
            [
                'TrMentoringScheduleId' => Str::uuid()->toString(),
                'MenteeUserId' => $menteeId3,
                'MentorUserId' => $mentorId,
                'UniqueCode' => 'B4D6',
                'MeetingTime' => now()->addDay()->format('Y-m-d') . ' 09:20:00',
                'MeetingLink' => 'https://meet.google.com/Kou4NfQUB',
                'SubjectId' => 1,
                'SpecificTopic' => 'Belajar CSS',
                'IsDone' => 0,
                'MenteeReview' => null,
            ],
            [
                'TrMentoringScheduleId' => Str::uuid()->toString(),
                'MenteeUserId' => $menteeId,
                'MentorUserId' => null,
                'UniqueCode' => 'V3B4',
                'MeetingTime' => now()->addDay()->format('Y-m-d') . ' 15:20:00',
                'MeetingLink' => null,
                'SubjectId' => 1,
                'SpecificTopic' => 'Belajar Laravel',
                'IsDone' => 0,
                'MenteeReview' => null,
            ],
            [
                'TrMentoringScheduleId' => Str::uuid()->toString(),
                'MenteeUserId' => $menteeId3,
                'MentorUserId' => null,
                'UniqueCode' => 'G7H1',
                'MeetingTime' => now()->addDay()->format('Y-m-d') . ' 13:20:00',
                'MeetingLink' => null,
                'SubjectId' => 1,
                'SpecificTopic' => 'Belajar React',
                'IsDone' => 0,
                'MenteeReview' => null,
            ],
            [
                'TrMentoringScheduleId' => Str::uuid()->toString(),
                'MenteeUserId' => $menteeId,
                'MentorUserId' => $mentorId,
                'UniqueCode' => 'O1A2',
                'MeetingTime' => now()->addDay()->format('Y-m-d') . ' 11:20:00',
                'MeetingLink' => 'https://meet.google.com/Abd1NfQLB',
                'SubjectId' => 1,
                'SpecificTopic' => 'Belajar Web',
                'IsDone' => 0,
                'MenteeReview' => null,
            ],
            [
                'TrMentoringScheduleId' => Str::uuid()->toString(),
                'MenteeUserId' => $menteeId3,
                'MentorUserId' => $mentorId,
                'UniqueCode' => 'F4G5',
                'MeetingTime' => '2024-06-14 15:20:00',
                'MeetingLink' => 'https://meet.google.com/ctVL1NfQLB',
                'SubjectId' => 1,
                'SpecificTopic' => 'Belajar Java',
                'IsDone' => 1,
                'MenteeReview' => 'Sangat bagus'
            ],
            [
                'TrMentoringScheduleId' => Str::uuid()->toString(),
                'MenteeUserId' => $menteeId,
                'MentorUserId' => $mentorId,
                'UniqueCode' => 'W3E4',
                'MeetingTime' => '2024-06-12 07:20:00',
                'MeetingLink' => 'https://meet.google.com/A45vffQLB',
                'SubjectId' => 1,
                'SpecificTopic' => 'Belajar Python',
                'IsDone' => 1,
                'MenteeReview' => null,
            ],
        ]);
    }
}
