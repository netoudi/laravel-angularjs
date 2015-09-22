<?php

use CodeProject\Entities\ProjectMember;
use Illuminate\Database\Seeder;

class ProjectMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ProjectMember::class, 50)->create();
    }
}
