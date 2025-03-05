<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Screening;
use Illuminate\View\View;
use App\Http\Requests\ScreeningFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class ScreeningController extends Controller
{
    public function index(Request $request): View
    {
        $screeningQuery = Screening::query();

        $filterByTitle = $request->query('title');

        if($filterByTitle !== null){
            $screeningQuery->whereHas('movie', function($moviesQuery) use($filterByTitle){
                $moviesQuery->where('title', 'LIKE', '%' . $filterByTitle . '%');
            });   
        }

        $today = date('Y-m-d');
        $todayHour = date('G:i:s');
        //$screeningQuery->where('date', '>=', $today);
        $screeningQuery->where(function ($query) use($today, $todayHour) {
            $query->where('date', '>', $today)
                  ->orWhere(function ($subQuery) use($today, $todayHour){
                    $subQuery->where('date', '=', $today)->where('start_time', '>=', $todayHour);
                  });
        });
        //$screeningQuery->where('date', '>=', $today)->where('start_time', '>=', $todayHour);

        $screenings = $screeningQuery->paginate(20)->withQueryString();

        return view('screening.index',compact('screenings', 'filterByTitle'));
    }

    public function show(Screening $screening): View
    {
        return view('screening.show',compact('screening'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $moviesQuery = Movie::query();

        $filterByTitle = $request->query('title');

        if($filterByTitle !== null){
            
            $moviesQuery->where('title', 'LIKE', '%' . $filterByTitle . '%');
              
        }

        $movies =$moviesQuery->paginate(20);
        //$newScreening = new Screening();

        return view('screening.chooseMovie',compact('movies', 'filterByTitle'));
    }

    public function createScreening(Movie $movie)
    {

        $newScreening = new Screening();
        $theaters = Theater::All()->pluck('name', 'id')->toArray();
        return view('screening.create')->with('screening',$newScreening)->with('movie',$movie)->with('theaters', $theaters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScreeningFormRequest $request, Movie $movie)
    {
        
        $validatedData = $request->validated();
        $hours = array();
            
        $validatedData['time13'] ? $hours[] = date('13:00:00') : null;
        $validatedData['time14'] ? $hours[] = date('14:00:00') : null;
        $validatedData['time16'] ? $hours[] = date('16:00:00') : null;
        $validatedData['time19'] ? $hours[] = date('19:00:00') : null;
        $validatedData['time21'] ? $hours[] = date('21:00:00') : null;
        $validatedData['time22'] ? $hours[] = date('22:00:00') : null;
        if(!$hours){
            $htmlMessage = "Need to put a starting time";
            return redirect()->back()
                ->with('alert-type', 'warning')
                ->with('alert-msg', $htmlMessage);

        }else{
            if($validatedData['date'] == date('Y-m-d')){

            
                $lowestTime = date('23:59:59');
                foreach($hours as $hour){
                    $lowestTime > $hour ? $lowestTime = $hour : null;
                } 
    
                if($lowestTime >= date('G:i:s') ){
                    
                    $day = $validatedData['date'];
                    if($day > $validatedData['dateLast']){
    
                        $htmlMessage = "Need to put a finishing date that is higher or equals than the starting date";
                        return redirect()->back()
                        ->with('alert-type', 'warning')
                        ->with('alert-msg', $htmlMessage);
                    }else{
    
                        $newScreening = DB::transaction(function () use ($validatedData, $movie, $hours) {
                            $newScreening = new Screening();
                            /*'date' => ['required', 'date'],
                            'theater' => ['required'],
                            'timeFrame' => ['required'],
                            'dateLast' => ['required', 'date'],*/
                            
                            $day = $validatedData['date'];
                            $day_jump;
                            $validatedData['timeFrame'] == 'Once a Week' ? $day_jump = 7 : null;
                            $validatedData['timeFrame'] == 'Every Day' ? $day_jump = 1 : null;
                            $validatedData['timeFrame'] == 'Once a month' ? $day_jump = 31 : null;
                            
    
                            while($day <= $validatedData['dateLast']){
                                foreach($hours as $hour){
    
                                    $newScreening = new Screening();
                                    $newScreening->movie_id = $movie->id;
                                    $newScreening->theater_id = $validatedData['theater'];
                                    $newScreening->date = $day;
                                    $newScreening->start_time = $hour;
                                    $newScreening->save();
                                }
    
    
                                $day = date('Y-m-d', strtotime($day . ' +'.$day_jump. ' day'));
                                
                            }                        
                            
                            return $newScreening;
                        });
                        
                        $htmlMessage = "Screenings  has been created successfully!";
                        return redirect()->route('screenings.index')
                            ->with('alert-type', 'success')
                            ->with('alert-msg', $htmlMessage);
                    }
                }else{
                    
                    $htmlMessage = "Need to put a starting date that is higher or equals than today";
                    return redirect()->back()
                        ->with('alert-type', 'warning')
                        ->with('alert-msg', $htmlMessage);
                }
                

            }else if($validatedData['date'] >= date('Y-m-d')){
                
                
                $day = $validatedData['date'];
                if($day > $validatedData['dateLast']){
    
                    $htmlMessage = "Need to put a finishing date that is higher or equals than the starting date";
                    return redirect()->back()
                    ->with('alert-type', 'warning')
                    ->with('alert-msg', $htmlMessage);
    
                }else{
                    //bom
                    $newScreening = DB::transaction(function () use ($validatedData, $movie, $hours) {
                        $newScreening = new Screening();
                        /*'date' => ['required', 'date'],
                        'theater' => ['required'],
                        'timeFrame' => ['required'],
                        'dateLast' => ['required', 'date'],*/
                        
                        $day = $validatedData['date'];
                        $day_jump;
                        $validatedData['timeFrame'] == 'Once a Week' ? $day_jump = 7 : null;
                        $validatedData['timeFrame'] == 'Every Day' ? $day_jump = 1 : null;
                        $validatedData['timeFrame'] == 'Once a month' ? $day_jump = 31 : null;
                        

                        while($day <= $validatedData['dateLast']){
                            foreach($hours as $hour){

                                $newScreening = new Screening();
                                $newScreening->movie_id = $movie->id;
                                $newScreening->theater_id = $validatedData['theater'];
                                $newScreening->date = $day;
                                $newScreening->start_time = $hour;
                                $newScreening->save();
                            }


                            $day = date('Y-m-d', strtotime($day . ' +'.$day_jump. ' day'));
                            
                        }                        
                        
                        return $newScreening;
                    });
                    
                    $htmlMessage = "Screenings  has been created successfully!";
                    return redirect()->route('screenings.index')
                        ->with('alert-type', 'success')
                        ->with('alert-msg', $htmlMessage);
                }
                
            }else{
                
                    $htmlMessage = "Need to put a starting date that is higher or equals than today";
                    return redirect()->back()
                        ->with('alert-type', 'warning')
                        ->with('alert-msg', $htmlMessage);
            }
        }
        

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Screening $screening) : View
    {
        
        return view('screening.edit',compact('screening'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ScreeningFormRequest $request, Screening $screening)
    {

        $validatedData = $request->validated();
        if($validatedData['date'] == date('Y-m-d')){

            if($validatedData['time'] >= date('G:i:s')){
                $screening = DB::transaction(function () use ($validatedData, $screening, $request) {
                    $screening->date = $validatedData['date'];
                    $screening->start_time = $validatedData['time'];
                    $screening->save();
                    
                    return $screening;
                });
        
                $url = route('screenings.show', ['screening' => $screening]);
                $htmlMessage = "Screening <a href='$url'><u>{$screening->movie->title} in {$screening?->theater?->name} {$screening->date} {$screening->start_time}</u></a> has been updated successfully!";
                return redirect()->back()
                    ->with('alert-type', 'success')
                    ->with('alert-msg', $htmlMessage);
            }else{
                $url = route('screenings.show', ['screening' => $screening]);
                $htmlMessage = "Need to put a date that is higher or equals than today";
                return redirect()->back()
                    ->with('alert-type', 'warning')
                    ->with('alert-msg', $htmlMessage);
            }
            

        }else if($validatedData['date'] >= date('Y-m-d')){
            
            $screening = DB::transaction(function () use ($validatedData, $screening, $request) {
                $screening->date = $validatedData['date'];
                $screening->start_time = $validatedData['time'];
                $screening->save();
                
                return $screening;
            });
    
            $url = route('screenings.show', ['screening' => $screening]);
            $htmlMessage = "Screening <a href='$url'><u>{$screening->movie->title} in {$screening?->theater?->name} {$screening->date} {$screening->start_time}</u></a> has been updated successfully!";
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', $htmlMessage);
            
        }else{
            $url = route('screenings.show', ['screening' => $screening]);
                $htmlMessage = "Need to put a date that is higher or equals than today";
                return redirect()->back()
                    ->with('alert-type', 'warning')
                    ->with('alert-msg', $htmlMessage);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Screening $screening)
    {
        try {

            $url = route('screenings.show', ['screening' => $screening]);

            $totalticket = $screening->ticket->count();
            
            if ($totalticket == 0) {
                
                $title = $screening->movie->title;
                $date = $screening->date;
                $time = $screening->start_time;
                $name_theater= $screening?->theater?->name;
                
                $screening->delete();

                
                $alertType = 'success';
                $alertMsg = "Screening of {$title} in {$name_theater} {$date} {$time} has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $alertMsg = "Screening <a href='$url'><u>{$screening->movie->title} in {$screening?->theater?->name} {$screening->date} {$screening->start_time}</u></a> cannot be deleted because still has $totalticket screening sessions to be shown.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the Screening <a href='$url'><u>{$screening->movie->title} in {$screening?->theater?->name} {$screening->date} {$screening->start_time}</u></a> because there was an error with the operation!";
        }
        return redirect()->route('screenings.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
        
    }
}
