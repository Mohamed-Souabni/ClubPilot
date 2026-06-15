<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->uuid('batch_id')->nullable()->after('id');
            $table->foreignId('created_by')->nullable()->after('club_id')->constrained('users')->nullOnDelete();
            $table->timestamp('read_at')->nullable()->after('is_read');
            $table->index(['club_id', 'batch_id']);
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['club_id', 'batch_id']);
            $table->dropConstrainedForeignId('created_by');
            $table->dropColumn(['batch_id', 'read_at']);
        });
    }
};
