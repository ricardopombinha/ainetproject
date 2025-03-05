<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\AccessController;
use App\Models\User;

use App\Exports\ScreeningsExport;
use App\Exports\PaymentTypesExport;
use App\Exports\TotalTicketsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/

/*Route::middleware('auth', 'can:profileUpdate')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->can('update', User::class);
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users', [ProfileController::class, 'index'])->name('profile.index')->can('viewAny', User::class);
    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('profile.show')->can('viewAny', User::class);
    Route::get('/users/edit/{user}', [ProfileController::class, 'editUser'])->name('profile.editUser')->can('viewAny', User::class);
    Route::delete('/users/destroy/{user}', [ProfileController::class, 'destroyByAdmin'])->name('profile.destroyByAdmin')->can('viewAny', User::class);
    Route::patch('/users/update/admin/{user}', [ProfileController::class, 'updateAdmin'])->name('profile.updateAdmin')->can('viewAny', User::class);
    Route::patch('/users/block/{user}', [ProfileController::class, 'blockUser'])->name('profile.blockUser')->can('viewAny', User::class);
    Route::delete('/users/destroy/{user}/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.destroyPhoto')->can('viewAny', User::class);
    Route::get('/users/create', [ProfileController::class, 'create'])->name('profile.create')->can('viewAny', User::class);;
});
//fazer path do index e fazer path de user individual para o administrador

require __DIR__.'/auth.php';



Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('movies',[MovieController::class,'index'])->name('movies.index');
Route::get('tickets/{movie}',[TicketController::class,'show'])->name('tickets.show'); 
Route::get('tickets/seats/{screening}', [TicketController::class, 'mostrarBilhetes'])->name('tickets.seats');

//tem se proteger esta route para acessos indefinios tem de ser auth e tipo C e A
Route::get('myTickets',[TicketController::class,'myTickets'])->name('tickets.myTickets');
Route::get('myTickets/{ticket}',[TicketController::class,'myTicketsGetTicket'])->name('tickets.myTickets.html');
Route::get('downloadTicket/{ticket}',[PdfController::class,'downloadTicket'])->name('pdfs.downloadTicket');


Route::get('pdfTicket/{purchase}',[PdfController::class,'generateTicket'])->name('pdfs.generateTicket');
Route::get('downloadTicket/Receipt/{purchase_id}',[PdfController::class,'downloadReceiptAndTicket'])->name('pdfs.downloadReceiptAndTicket');




//router de gestao do admin
Route::middleware('can:admin', 'auth')->group(function () {

    //route do theater
    Route::get('theater',[TheaterController::class,'index'])->name('theaters.index');
    Route::get('theater/edit/{theater}',[TheaterController::class,'edit'])->name('theaters.edit');
    Route::delete('theater/destroy/{theater}',[TheaterController::class,'destroy'])->name('theaters.destroy');
    Route::get('theater/create',[TheaterController::class,'create'])->name('theaters.create');
    Route::get('theater/show/{theater}',[TheaterController::class,'show'])->name('theaters.show');
    Route::put('theater/update/{theater}',[TheaterController::class,'update'])->name('theaters.update');
    Route::post('theater/store',[TheaterController::class,'store'])->name('theaters.store');
    Route::delete('theater/destroy/{theater}/photo',[TheaterController::class,'destroyPhoto'])->name('theaters.photo.destroy');

    //route do movies
    Route::get('movies/management',[MovieController::class,'managementIndex'])->name('movies.management.index');
    Route::get('movies/management/create',[MovieController::class,'create'])->name('movies.create');
    Route::get('movies/management/show/{movie}',[MovieController::class,'show'])->name('movies.show');
    Route::get('movies/management/edit/{movie}',[MovieController::class,'edit'])->name('movies.edit');
    Route::delete('movies/management/delete/{movie}',[MovieController::class,'destroy'])->name('movies.destroy');
    Route::put('movies/management/update/{movie}',[MovieController::class,'update'])->name('movies.update');
    Route::post('movies/management/store',[MovieController::class,'store'])->name('movies.store');
    Route::delete('movies/management/{movie}/poster',[MovieController::class,'destroyPoster'])->name('movies.poster.destroy');

    //route do genres
    Route::get('genre',[GenreController::class,'index'])->name('genres.index');
    Route::get('genre/create',[GenreController::class,'create'])->name('genres.create');
    Route::get('genre/show/{genre}',[GenreController::class,'show'])->name('genres.show');
    Route::get('genre/edit/{genre}',[GenreController::class,'edit'])->name('genres.edit');
    Route::delete('genre/delete/{genre}',[GenreController::class,'destroy'])->name('genres.destroy');
    Route::put('genre/update/{genre}',[GenreController::class,'update'])->name('genres.update');
    Route::post('genre/store',[GenreController::class,'store'])->name('genres.store');

    //route do screenings
    Route::get('screening',[ScreeningController::class,'index'])->name('screenings.index');
    Route::get('screening/create',[ScreeningController::class,'create'])->name('screenings.create');
    Route::get('screening/create/{movie}',[ScreeningController::class,'createScreening'])->name('screenings.createScreening');
    Route::get('screening/show/{screening}',[ScreeningController::class,'show'])->name('screenings.show');
    Route::get('screening/edit/{screening}',[ScreeningController::class,'edit'])->name('screenings.edit');
    Route::delete('screening/delete/{screening}',[ScreeningController::class,'destroy'])->name('screenings.destroy');
    Route::put('screening/update/{screening}',[ScreeningController::class,'update'])->name('screenings.update');
    Route::post('screening/store/{movie}',[ScreeningController::class,'store'])->name('screenings.store');

    Route::get('statistics',[StatisticsController::class,'index'])->name('statistics.index');

    //route Rod
    Route::get('export/screenings', function () {
        return Excel::download(new ScreeningsExport, 'screenings.xlsx');
    })->name('export.screenings');

    Route::get('export/payment-types', function () {
        return Excel::download(new PaymentTypesExport, 'payment_types.xlsx');
    })->name('export.payment_types');


    Route::get('export/total-tickets', function () {
        return Excel::download(new TotalTicketsExport, 'total_tickets.xlsx');
    })->name('export.total_tickets');

});



//Ric
//Add
Route::post('cart/{seat}/{screening}', [CartController::class, 'addToCart'])->name('cart.add');
// Remove a ticket from the cart:
Route::delete('cart/{seat}', [CartController::class, 'removeFromCart'])->name('cart.remove');
// Show the cart:
Route::get('cart', [CartController::class, 'show'])->name('cart.show');
// Confirm (store) the cart and save tickets registration on the database:
Route::post('cartAuth', [CartController::class, 'confirmAuth'])->name('cart.confirmAuth');
Route::post('cart', [CartController::class, 'confirm'])->name('cart.confirm');


// Clear the cart:
Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('paymenttype', [PaymentController::class, 'showPaymentType'])->name('paymenttype.show');
Route::post('paymenttypeAuth', [PaymentController::class, 'showPaymentTypeAuth'])->name('paymenttype.showAuth');


Route::post('paymentinfo', [PaymentController::class, 'showPaymentInfo'])->name('paymentinfo.show');
Route::post('paymentinfoAuth', [PaymentController::class, 'showPaymentInfoAuth'])->name('paymentinfo.showAuth');

Route::post('paymentResult', [PaymentController::class, 'store'])->name('paymentResult.store');

Route::post('paymentfinalinfo', [PaymentController::class, 'showPaymentFinalInfo'])->name('paymentfinalinfo.show');





Route::middleware('can:accessControl', 'auth')->group(function () {
    Route::get('access',[AccessController::class,'index'])->name('access.index');
    Route::get('access/{screening}',[AccessController::class,'show'])->name('access.show');
    Route::post('access/validate/{screening}',[TicketController::class,'validateTicket'])->name('access.validateTicket'); 
    Route::post('access/ticketInvalidate/{ticket}',[AccessController::class,'ticketInvalidate'])->name('access.ticketInvalidate');

});