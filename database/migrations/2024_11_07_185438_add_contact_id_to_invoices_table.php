<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::table('invoices', function (Blueprint $table) {
                $table->foreignId('contact_id')->constrained()->onDelete('cascade')->after('id');
            });
        }

        public function down()
        {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropForeign(['contact_id']);
                $table->dropColumn('contact_id');
            });
        }
    };