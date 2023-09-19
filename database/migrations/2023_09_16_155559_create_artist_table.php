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
        Schema::create('artist', function (Blueprint $table) {
            $table->string("spotify_id")->primary();
            $table->integer("total_followers");
            $table->string("name");
            $table->integer("popularity");
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artist', function (Blueprint $table) {
            $table->dropPrimary('artist_spotify_id_primary');
        });
    }
};
