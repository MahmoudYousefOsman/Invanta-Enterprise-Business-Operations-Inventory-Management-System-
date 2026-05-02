<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('engineer_id')->constrained('engineers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('created_by')->constrained('admins')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('device_type');
            $table->string('serial_number');
            $table->text('description');
            $table->text('notes')->nullable();
            $table->decimal('commission')->nullable();
            $table->enum('status', ['new', 'completed', 'cancelled'])->default('new');
            $table->decimal('cost', 8, 2);
            $table->decimal('payed', 8, 2)->nullable();
            $table->date('receipt_date');
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
