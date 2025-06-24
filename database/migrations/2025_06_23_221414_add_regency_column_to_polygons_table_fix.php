<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('polygons', function (Blueprint $table) {
            if (!Schema::hasColumn('polygons', 'regency')) {
                $table->string('regency')->after('id')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('polygons', function (Blueprint $table) {
            if (Schema::hasColumn('polygons', 'regency')) {
                $table->dropColumn('regency');
            }
        });
    }
};
