<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
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

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

    public function profile(){

        return view('profile.index');
    }
    public function rating_list($name) {
      // Fetch complaints handled by the given name
      $rows = DB::table('complaints')->where('handle_by', $name)->get(); // No need for toArray()
  
      $avgUserRatings = 0;
      $totalReviews = 0;
      $totalRatings5 = 0;
      $totalRatings4 = 0;
      $totalRatings3 = 0;
      $totalRatings2 = 0;
      $totalRatings1 = 0;
      $ratingsList = [];
      $totalRatings_avg = 0;
  
      // Loop through each complaint row (which are objects in the collection)
      foreach ($rows as $row) {
          // Check if properties exist
          if (isset($row->stars_rated) && isset($row->handle_by) && isset($row->created_at)) {
              // Populate the ratings list
              $ratingsList[] = [
                  'name' => $row->handle_by,
                  'rating' => $row->stars_rated,
                  'datetime' => date('l jS \of F Y h:i:s A', strtotime($row->created_at))
              ];
  
              // Update the ratings counts based on the rating value
              switch ($row->stars_rated) {
                  case '5':
                      $totalRatings5++;
                      break;
                  case '4':
                      $totalRatings4++;
                      break;
                  case '3':
                      $totalRatings3++;
                      break;
                  case '2':
                      $totalRatings2++;
                      break;
                  case '1':
                      $totalRatings1++;
                      break;
              }
  
              // Increment the total reviews and update the average rating
              $totalReviews++;
              $totalRatings_avg += intval($row->stars_rated);
          }
      }
  
      // Calculate the average user rating
      if ($totalReviews > 0) {
          $avgUserRatings = $totalRatings_avg / $totalReviews;
      }
      //dd($totalRatings_avg);
  
      // Prepare the output array
      $output = [
          'avgUserRatings' => number_format($avgUserRatings, 1),
          'totalReviews' => $totalReviews,
          'totalRatings5' => $totalRatings5,
          'totalRatings4' => $totalRatings4,
          'totalRatings3' => $totalRatings3,
          'totalRatings2' => $totalRatings2,
          'totalRatings1' => $totalRatings1,
          'ratingsList' => $ratingsList
      ];
  
      return response()->json($output);
  }

  public function store(Request $request){
    dd($request->all());
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        ]);
        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
            }
            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            //return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
            dd($token);
  }
  

}