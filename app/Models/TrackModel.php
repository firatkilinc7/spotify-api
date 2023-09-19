<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackModel extends Model
{
    use HasFactory;
    protected $table= "tracks";
    public $primaryKey = "spotify_id";

    public $timestamps = true;
    public $incrementing = false;

    protected $fillable = [
        "album_id",
        "artist_id",
        "name",
        "duration",
        "explicit"
    ];

    protected $guarded = [
        "spotify_id",
    ];

    public function getAlbum(){
        return $this->belongsTo(AlbumModel::class, "album_id");
    }

    public function getArtist(){
        return $this->belongsTo(ArtistModel::class, "artist_id");
    }


}
