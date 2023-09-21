<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->uuid("id")->primary()->default(DB::raw('UUID()'));
            $table->string("spotify_id");
            $table->uuid("album_id")->nullable();
            $table->uuid("artist_id")->nullable();
            $table->string("name");
            $table->integer("duration");
            $table->boolean("explicit");
            $table->timestamps();

            $table->foreign("album_id")->references("id")->on("albums")->onDelete("set null")->onUpdate("cascade");
            $table->foreign("artist_id")->references("id")->on("artist")->onDelete("set null")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
