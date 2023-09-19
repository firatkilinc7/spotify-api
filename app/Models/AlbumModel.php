<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumModel extends Model
{

    use HasFactory;
    protected $table= "albums";
    public $primaryKey = "spotify_id";

    public $timestamps = true;
    public $incrementing = false;

    protected $fillable = [
        "artist_id",
        "name",
        "release_date",
        "total_track",
    ];

    protected $guarded = [
        "spotify_id",
    ];

    public function getArtist(){
        return $this->belongsTo(ArtistModel::class, "artist_id");
    }
}
