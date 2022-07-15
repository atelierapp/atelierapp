<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameTableFromStoreUserQualifiesToStoreUserRatings extends Migration
{
    public function up()
    {
        Schema::rename('store_user_qualifies', 'store_user_ratings');
    }

    public function down()
    {
        Schema::rename('store_user_ratings', 'store_user_qualifies');
    }
}
