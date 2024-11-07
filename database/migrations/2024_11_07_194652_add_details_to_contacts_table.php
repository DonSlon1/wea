<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddDetailsToContactsTable extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up()
        {
            Schema::table('contacts', function (Blueprint $table) {
                $table->string('phone_number')->after('email');
                $table->string('address')->nullable()->after('phone_number');
                $table->string('city')->nullable()->after('address');
                $table->string('state')->nullable()->after('city');
                $table->string('zip_code')->nullable()->after('state');
                $table->string('company_name')->nullable()->after('zip_code');
                $table->string('website')->nullable()->after('company_name');
                $table->text('notes')->nullable()->after('website');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down()
        {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn([
                    'phone_number',
                    'address',
                    'city',
                    'state',
                    'zip_code',
                    'company_name',
                    'website',
                    'notes',
                ]);
            });
        }
    }
