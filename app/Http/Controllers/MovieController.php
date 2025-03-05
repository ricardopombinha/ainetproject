<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Screening;
use Illuminate\View\View;
use App\Http\Requests\MovieFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index(Request $request): View
    {
        $genres = Genre::All();

        $filterByGenre = $request->query('genre');
        $filterByTitle = $request->title;
        $filterBySubString = $request->subString;

        
        $moviesQuery = Movie::query();

        $today = date('Y-m-d');
        $fourteenDaysFromNow = date('Y-m-d', strtotime('+14 days'));

      
        $movieIdsWithScreeningsDateWithin2weeks = DB::table('screenings')
            ->where('date', '>=', $today)
            ->where('date', '<=', $fourteenDaysFromNow)
            ->pluck('movie_id')
            ->toArray();

        $moviesQuery->whereIntegerInRaw('id', $movieIdsWithScreeningsDateWithin2weeks);

        if ($filterByGenre !== null) {
            $moviesQuery->where('genre_code', $filterByGenre);
        }
       
        if ($filterByTitle !== null) {
            $moviesIds = DB::table('movies')
                ->where('title', 'like', "%$filterByTitle%")
                ->pluck('id')
                ->toArray();

            $moviesQuery->whereIntegerInRaw('id', $moviesIds);
        }
        $movies = $moviesQuery->paginate(20)->withQueryString();
        return view(
            'movies.index',
            compact('movies', 'filterByGenre', 'filterByTitle', 'filterBySubString', 'genres')
        );
    }

    public function managementIndex(Request $request): View
    {
        $moviesQuery = Movie::query();

        $filterByTitle = $request->query('title');

        if($filterByTitle !== null){
            $moviesQuery->where('title', 'LIKE', '%' . $filterByTitle . '%');
        }

        $movies = $moviesQuery->paginate(20)->withQueryString();

        return view('movies.managementIndex',compact('movies', 'filterByTitle'));

    }

    public function show(Movie $movie): View
    {
        $genres = Genre::pluck('name','code')->toArray();
        return view('movies.show',compact('movie', 'genres'));
    }

    
    public function create()
    {
        $newMovie = new Movie();
        $genres = Genre::pluck('name','code')->toArray();
        return view('movies.create')->with('movie', $newMovie)->with('genres', $genres);
    }

    
    public function store(MovieFormRequest $request)
    {
        $validatedData = $request->validated();
        $newMovie = DB::transaction(function () use ($validatedData, $request) {
            $newMovie = new Movie();
            $newMovie->title = $validatedData['title'];
            $newMovie->year = $validatedData['year'];
            $newMovie->genre_code = $validatedData['genre'];
            $newMovie->synopsis = $validatedData['synopsis'];
            if ($request->has('trailer_url')){
                $newMovie->trailer_url = $validatedData['trailer_url'];
            }
            
            if ($request->hasFile('image_file')) {
                $path = $request->image_file->store('public/posters');
                $newMovie->poster_filename = basename($path);
            }
            $newMovie->save(); 
            
            
            
            return $newMovie;
        });
        $url = route('movies.show', ['movie' => $newMovie]);
        $htmlMessage = "Movie <a href='$url'><u>{$newMovie->title}</u></a> has been created successfully!";
        return redirect()->route('movies.management.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    
    public function edit(Movie $movie) : View
    {
        //$genre = Genre::All();
        $genres = Genre::pluck('name','code')->toArray();
        //dd($genre_array);
        return view('movies.edit',compact('movie', 'genres'));
    }

    
    public function update(MovieFormRequest $request, Movie $movie)
    {
        $validatedData = $request->validated();
        $movie = DB::transaction(function () use ($validatedData, $movie, $request) {
            $movie->title = $validatedData['title'];
            $movie->year = $validatedData['year'];
            $movie->genre_code = $validatedData['genre'];
            $movie->synopsis = $validatedData['synopsis'];
            $movie->trailer_url = $validatedData['trailer_url'];
            $movie->save();
            if ($request->hasFile('image_file')) {
                // Delete previous file (if any)
                if (
                    $movie->photo_filename &&
                    Storage::fileExists('public/posters/' . $movie->poster_filename)
                ) {
                    Storage::delete('public/posters/' . $movie->poster_filename);
                }
                $path = $request->image_file->store('public/posters');
                $movie->poster_filename = basename($path);
                $movie->save();
            }
            return $movie;
        });
        $url = route('movies.show', ['movie' => $movie]);
        $htmlMessage = "theater <a href='$url'><u>{$movie->title}</u></a> has been updated successfully!";
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    
    public function destroy(Movie $movie)
    {
        try {

            $url = route('movies.show', ['movie' => $movie]);
            
            $screeningQuery = Screening::query();
            $movie_id = $movie->id;
            $today = date('Y-m-d');
            $todayHour = date('G:i:s');
            $screeningQuery->where('movie_id', $movie->id)->where('date', '>=', $today)->where('start_time', '>=', $todayHour);

            $totalScreening = $screeningQuery->get()->count();
            
            if ($totalScreening == 0) {
                
                $fileToDelete = $movie?->poster_filename;
                $name = $movie->name;
                
                $movie->delete();

                if ($fileToDelete) {
                    if (Storage::fileExists('public/posters/' . $fileToDelete)) {
                        Storage::delete('public/posters/' . $fileToDelete);
                    }
                }
                $alertType = 'success';
                $alertMsg = "Movie {$name} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $alertMsg = "Movie <a href='$url'><u>{$movie->name}</u></a> cannot be deleted because still has $totalScreening screening sessions to be shown.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the Movie <a href='$url'><u>{$movie->title}</u></a> because there was an error with the operation!";
        }
        return redirect()->route('movies.management.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
        
    }

    public function destroyPoster(Movie $movie)
    {
        if ($movie->poster_filename) {
            if (Storage::fileExists('public/posters/' . $movie->poster_filename)) {
                Storage::delete('public/posters/' . $movie->poster_filename);
            }
            $movie->poster_filename = null;
            $movie->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Poster of {$movie->title} has been deleted.");
        }
        return redirect()->back();
        
    }
}
