<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistModel extends Model
{
    use HasFactory;
    protected $table= "artist";
    public $primaryKey = "id";

    public $timestamps = true;
    public $incrementing = false;

    protected $fillable = [
        "id",
        "spotify_id",
        "total_followers",
        "name",
        "popularity",
        "spotify_id"
    ];



    public function artistGenres(){
        return $this->belongsToMany(GenreModel::class, "artist_meta", "artist_id", "genre_id");
    }

    public function getAlbums(){
        return $this->hasMany(AlbumModel::class, "artist_id");
    }
}
