<?php

namespace App\Http\Controllers;

use App\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilmController extends Controller
{
    //
    public function store($filmId)
    {
        $auth = Auth::user();
        // dd($filmId);
        // dd($auth->id);
        $filmCheck = Film::where([['film_id', $filmId], ['user_id', $auth->id]])->first();
        // dd($filmCheck);
        if ($filmCheck) {
            $filmCheck->delete();
            return "{\"exists\":false}";
        } else {

            $film = new Film();
            $film->film_id = $filmId;
            $film->user_id = $auth->id;
            $film->save();
            return "{\"exists\":true}";
        }
    }

    public function check($filmId)
    {
        $auth = Auth::user();
        $filmCheck = Film::where([['film_id', $filmId], ['user_id', $auth->id]])->first();
        if ($filmCheck) {
            return "{\"exists\":true}";
        }
        return "{\"exists\":false}";
    }
}
