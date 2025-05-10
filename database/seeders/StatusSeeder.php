<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;
use App\Models\StatusProject;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = ['Pending', 'Approve', 'Reject'];

        foreach ($statuses as $status) {
            ProjectStatus::updateOrCreate(
                ['nama' => $status],
                ['nama' => $status]
            );
        }
    }
}
