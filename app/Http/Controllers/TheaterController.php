<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;
use App\Models\Screening;
use App\Models\Seat;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TheaterFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class TheaterController extends Controller
{

    public function index(): View
    {
        $theaters = Theater::All();

        return view('theaters.index', compact('theaters'));
    }

    public function show(Theater $theater): View
    {
        return view('theaters.show')->with('theater', $theater);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newTheater = new Theater();
        return view('theaters.create')->with('theater', $newTheater);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TheaterFormRequest $request)
    {
        $validatedData = $request->validated();
        $newTheater = DB::transaction(function () use ($validatedData, $request) {
            $newTheater = new Theater();
            $newTheater->name = $validatedData['name'];
            if ($request->hasFile('photo_file')) {
                $path = $request->photo_file->store('public/theaters');
                $newTheater->photo_filename = basename($path);
            }
            //dd($newTheater);
            $newTheater->save(); 
            
            
            $array_ABC = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O'];
            for($i = 0; $i < $validatedData['rows']; $i++){
                
                for($j = 1; $j <= $validatedData['seats']; $j++){
                    $newSeat = new Seat();
                    $newSeat->theater_id = $newTheater->id;
                    $newSeat->row = $array_ABC[$i];
                    $newSeat->seat_number = $j;
                    $newSeat->save(); 
                }
            }
            return $newTheater;
        });
        $url = route('theaters.show', ['theater' => $newTheater]);
        $htmlMessage = "Theater <a href='$url'><u>{$newTheater->name}</u></a> has been created successfully!";
        return redirect()->route('theaters.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    /**public function show(Ticket $ticket)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theater $theater) : View
    {
        return view('theaters.edit')->with('theater', $theater);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TheaterFormRequest $request, Theater $theater)
    {
        $validatedData = $request->validated();
        $student = DB::transaction(function () use ($validatedData, $theater, $request) {
            $theater->name = $validatedData['name'];
            $theater->save();
            if ($request->hasFile('photo_file')) {
                // Delete previous file (if any)
                if (
                    $theater->photo_filename &&
                    Storage::fileExists('public/theaters/' . $theater->photo_filename)
                ) {
                    Storage::delete('public/theaters/' . $theater->photo_filename);
                }
                $path = $request->photo_file->store('public/theaters');
                $theater->photo_filename = basename($path);
                $theater->save();
            }
            return $theater;
        });
        $url = route('theaters.show', ['theater' => $theater]);
        $htmlMessage = "theater <a href='$url'><u>{$theater->name}</u></a> has been updated successfully!";
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theater $theater)
    {
            
        try {

            $url = route('theaters.show', ['theater' => $theater]);
            
            $screeningQuery = Screening::query();
            $theater_id = $theater->id;
            $today = date('Y-m-d');
            $todayHour = date('G:i:s');
            $screeningQuery->where('theater_id', $theater->id)->where('date', '>=', $today)->where('start_time', '>=', $todayHour);

            $totalScreening = $screeningQuery->get()->count();
            
            if ($totalScreening == 0) {
                
                $fileToDelete = $theater?->photo_filename;
                $name = $theater->name;
                $seats = $theater->seat;
                
                $theater->delete();

                foreach($seats as $seat){
                    $seat->delete();
                }

                if ($fileToDelete) {
                    if (Storage::fileExists('public/theaters/' . $fileToDelete)) {
                        Storage::delete('public/theaters/' . $fileToDelete);
                    }
                }
                
                $alertType = 'success';
                $alertMsg = "Theater {$name} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $alertMsg = "Theater <a href='$url'><u>{$theater->name}</u></a> cannot be deleted because still has $totalScreening screening sessions to be shown.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the Theater <a href='$url'><u>{$theater->name}</u></a> because there was an error with the operation!";
        }
        return redirect()->route('theaters.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyPhoto(Theater $theater): RedirectResponse
    { 
        if ($theater->photo_filename) {
            if (Storage::fileExists('public/theaters/' . $theater->photo_filename)) {
                Storage::delete('public/theaters/' . $theater->photo_filename);
            }
            $theater->photo_filename = null;
            $theater->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of theater {$theater->name} has been deleted.");
        }
        return redirect()->back();
    }

}
