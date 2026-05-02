<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('invoice_returns', function (Blueprint $table) {
                $table->id();

                $table->string('code')->unique();

                $table->enum('type', ['client', 'supplier']);

                $table->unsignedBigInteger('type_id');

                $table->text('notes')->nullable();

                $table->decimal('total_price', 10, 2)->default(0);

                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('invoice_returns');
        }
    };
