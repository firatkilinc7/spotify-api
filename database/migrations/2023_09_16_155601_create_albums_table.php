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
        Schema::create('albums', function (Blueprint $table) {
            $table->string("spotify_id")->primary();
            $table->string("artist_id")->nullable();
            $table->string("name");
            $table->date("release_date");
            $table->integer("total_track");
            $table->timestamps();

            $table->foreign("artist_id")->references("spotify_id")->on("artist")->onDelete("set null")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropPrimary('albums_spotify_id_primary');
        });
    }
};
