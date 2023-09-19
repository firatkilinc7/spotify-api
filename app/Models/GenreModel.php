<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenreModel extends Model
{
    use HasFactory;
    protected $table= "genres";
    public $primaryKey = "id";

    public $timestamps = true;


    protected $fillable = [
        "name",
    ];

    protected $guarded = [
        "id",
    ];

    public function genresArtist(){
        return $this->belongsToMany(ArtistModel::class, "artist_meta", "genre_id", "artist_id");
    }
}
