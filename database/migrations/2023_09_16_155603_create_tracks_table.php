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
        Schema::create('tracks', function (Blueprint $table) {
            $table->string("spotify_id")->primary();
            $table->string("album_id")->nullable();
            $table->string("artist_id")->nullable();
            $table->string("name");
            $table->integer("duration");
            $table->boolean("explicit");
            $table->timestamps();

            $table->foreign("album_id")->references("spotify_id")->on("albums")->onDelete("set null")->onUpdate("cascade");
            $table->foreign("artist_id")->references("spotify_id")->on("artist")->onDelete("set null")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropPrimary('tracks_spotify_id_primary');
        });
    }
};
