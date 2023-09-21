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
        Schema::create('artist_meta', function (Blueprint $table) {
            $table->id();
            $table->uuid("artist_id");
            $table->uuid("genre_id");
            $table->timestamps();

            $table->foreign("artist_id")->references("id")->on("artist")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("genre_id")->references("id")->on("genres")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_meta');
    }
};
