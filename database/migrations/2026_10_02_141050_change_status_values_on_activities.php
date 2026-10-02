<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('status', 20)->default('draft')->change();
        });

        DB::table('activities')->where('status', 'Planned')->update(['status' => 'draft']);
        DB::table('activities')->where('status', 'Ongoing')->update(['status' => 'published']);
        DB::table('activities')->where('status', 'Done')->update(['status' => 'completed']);
    }

    public function down(): void
    {
        DB::table('activities')->where('status', 'draft')->update(['status' => 'Planned']);
        DB::table('activities')->where('status', 'published')->update(['status' => 'Ongoing']);
        DB::table('activities')->where('status', 'completed')->update(['status' => 'Done']);

        Schema::table('activities', function (Blueprint $table) {
            $table->string('status', 20)->default('Planned')->change();
        });
    }
};