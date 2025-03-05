<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    
    use AuthorizesRequests;

    public function __contruct()
    {
        $this->authorizeResource(User::Class);
    }


    public function index(Request $request): View
    {
        $typeOptions = User::groupBy('type')->select('type')->get()->pluck('type','type')->toArray();
        $typeOptions = array_merge([null => 'Any type'], $typeOptions);

        $usersQuery = User::query();

        $filterByType = $request->type;
        $filterByName = $request->query('name');

        if($filterByType !== null){
            debug($filterByType);
            $usersQuery->where('type', $filterByType);
        }
        if($filterByName !== null){
            $usersQuery->where('name', 'LIKE', '%' . $filterByName . '%');
        }

        //$users = User::paginate(20);
        $users = $usersQuery->paginate(20)->withQueryString();

        return view('profile.index',compact('users', 'filterByType', 'filterByName','typeOptions'));
    }
    public function create(): View
    {
        $newUser = new User();
        return view('profile.create')->with('user', $newUser);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    public function show(User $user): View
    {
        if($user->type == 'C'){
            abort(403);
        }
        return view('profile.show', [
            'user' => $user,
        ]);
    }

    public function editUser(User $user): View
    {
        if($user->type == 'C'){
            abort(403);
        }
        return view('profile.editUser', [
            'user' => $user,
        ]);
    }

    


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        /*$customer = $request->user()->customer;
        $$customer->update($request);*/
        
        if($request->user()->type == 'C'){
            //$request->user()->costumer->nif = $request['nif'];
            //$customer = $request->user()->costumer;
            $customer = Customer::findOrFail($request->user()->id);
            //$customer->nif = $request['nif'];
            $customer->fill($request->validated());
            $customer->save();
        }

        if ($request->hasFile('photo_file')) {
            // Delete previous file (if any)
            if (
                $request->user()->photo_filename &&
                Storage::fileExists('public/photos/' . $request->user()->photo_filename)
            ) {
                Storage::delete('public/photos/' . $request->user()->photo_filename);
            }
            $path = $request->photo_file->store('public/photos');
            $request->user()->photo_filename = basename($path);
            $request->user()->save();
        }
        

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function destroyByAdmin(User $user): RedirectResponse
    {   
        $url = route('profile.show', ['user' => $user]);
        try{
            /*if($user->type == 'C'){
                $alertType = 'warning';
                $alertMsg = "User {$user->name} is a Customer, you cant delete that account!";
            }*/
            if($user->id == Auth::user()->id){
                $alertType = 'Danger';
                $alertMsg = "You cant delete yourself!";
            }else{
                DB::transaction(function () use ($user){
                    $fileToDelete = $user->photoFullUrl;
                    $user->delete();
                    if($fileToDelete){
                        if (Storage::fileExists('public/photos/' . $fileToDelete)) {
                            Storage::delete('public/photos/' . $fileToDelete);
                        }
                    }
                });
                $alertType = 'success';
                $alertMsg = "User {$user->name} has been deleted successfully!";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the student
                            <a href='$url'><u>{$student->user->name}</u></a>
                            because there was an error with the operation!";
        }

        return redirect()->route('profile.index')->with('alert-type', $alertType)->with('alert-msg', $alertMsg);
        
    }

    public function updateAdmin(ProfileUpdateRequest $request, User $user): RedirectResponse
    {
        
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        if ($request->hasFile('photo_file')) {
            // Delete previous file (if any)
            if (
                $user->photo_filename &&
                Storage::fileExists('public/photos/' . $user->photo_filename)
            ) {
                Storage::delete('public/photos/' . $user->photo_filename);
            }
            $path = $request->photo_file->store('public/photos');
            $user->photo_filename = basename($path);
            $user->save();
        }

        return Redirect::route('profile.index')->with('status', 'profile-updated');
    }

    public function blockUser(User $user): RedirectResponse
    {
        if($user->blocked){
            $user->blocked = 0; 
        }else{
            $user->blocked = 1; 
        }

        $user->save();

        return Redirect::route('profile.index');
    }

    public function destroyPhoto(User $user)
    {
        if ($user->photo_filename) {
            if (Storage::fileExists('public/photos/' . $user->photo_filename)) {
                Storage::delete('public/photos/' . $user->photo_filename);
            }
            $user->photo_filename = null;
            $user->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Photo of {$user->name} has been deleted.");
        }
        return redirect()->back();
    }
}
