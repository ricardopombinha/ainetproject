<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Screening;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\GenreFormRequest;
use Illuminate\View\View;
use Carbon\Carbon;


class GenreController extends Controller
{
    public function index(): View
    {
        $genres = Genre::all();
        return view('genre.index')->with('genres', $genres);
    }

    public function show(Genre $genre): View
    {
        return view('genre.show',compact('genre'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newGenre = new Genre();
        return view('genre.create')->with('genre', $newGenre);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GenreFormRequest $request)
    {
        $newGenre = Genre::create($request->validated());
        
        $url = route('genres.show', ['genre' => $newGenre]);
        $htmlMessage = "Genre <a href='$url'><u>{$newGenre->name}</u></a> ({$newGenre->code}) has been created successfully!";
        return redirect()->route('genres.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre) : View
    {
        return view('genre.edit',compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GenreFormRequest $request, Genre $genre)
    {
        $validatedData = $request->validated();
        $genre = DB::transaction(function () use ($validatedData, $genre, $request) {
            $genre->name = $validatedData['name'];
            $genre->save();
            return $genre;
        });
        $url = route('genres.show', ['genre' => $genre]);
        $htmlMessage = "theater <a href='$url'><u>{$genre->code}</u></a> has been updated successfully!";
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        try {

            $url = route('genres.show', ['genre' => $genre]);
            
            $screeningQuery = Screening::query();
            $today = today()->format('Y-m-d');
            $todayHour = date('G:i:s');
            //dd(Carbon::now());
            //$today = Carbon::now();
            $screeningQuery->where('date', '>=', $today)->where('start_time', '>=', $todayHour);

            /*dd($screeningQuery->whereRaw("CONCAT(date, ' ', start_time) =>", [$currentDateTime])
            ->get()->count());*/
            $screeningQuery->whereHas(
                'movie',
                function ($movieQuery) use($genre) {
                    $movieQuery->where('genre_code', $genre->code);
                }
            );
            $totalScreening = $screeningQuery->get()->count();
            if ($totalScreening == 0) {

                $name = $genre->name;
                
                $genre->delete();

                $alertType = 'success';
                $alertMsg = "Genre {$name} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $alertMsg = "Genre <a href='$url'><u>{$genre->name}</u></a> cannot be deleted because still has $totalScreening screening sessions to be shown.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the Movie <a href='$url'><u>{$genre->name}</u></a> because there was an error with the operation!";
        }
        return redirect()->route('genres.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
        
    }
}
