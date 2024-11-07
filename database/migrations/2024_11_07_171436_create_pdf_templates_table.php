<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreatePdfTemplatesTable extends Migration
    {
        public function up()
        {
            Schema::create('pdf_templates', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Template name
                $table->text('blade_template'); // Blade template content
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('pdf_templates');
        }
    }
