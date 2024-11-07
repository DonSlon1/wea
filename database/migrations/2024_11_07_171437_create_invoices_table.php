<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateInvoicesTable extends Migration
    {
        public function up()
        {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                // Add relevant fields
                $table->string('invoice_number')->unique();
                $table->date('invoice_date');
                $table->decimal('amount', 10, 2);
                $table->text('description')->nullable();
                $table->foreignId('pdf_template_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('invoices');
        }
    }
