<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ShortUrls;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class UrlShortnerController extends Controller
{
    public function viewPage()
    {

        return view("urlShortnerForm")->with('data', "");
    }

    public function createShortner(Request $request)
    {
        //dd("12233");
        $builder = new \AshAllenDesign\ShortURL\Classes\Builder();

        $request->validate([
            'url' => 'required|url',
        ]);


        try {
            $originalUrl = $request->input('url');
            // Generate a random string with a specified length (e.g., 10 characters)
            $randomString = Str::random(5);
            // Check if the generated string already exists in the database
            while (ShortUrls::where('default_short_url', 'like', '%' . $randomString . '%')->count() > 0) {
                // Regenerate the random string if it already exists
                $randomString = Str::random(5);
            }
            // Retrieve the user by user_id
            $user = Packages::where('user_id', Auth::id())->first();
            //$isActive = 0; // default
            if ($user) {
                // Check if the user is active
                if ($user->is_active == 1) {
                 
                    $isActive = 1;
                } else {
                 
                    $countOftotalURL = ShortUrls::where('user_id', Auth::id())->count();
                    $isActive = ($countOftotalURL >=10) ? 0 : 1;
                }
            }else{
                $isActive = 1; // new user 
            }
           
            if ($isActive==1) {
                $shortURLObject = $builder->destinationUrl($originalUrl)->urlKey($randomString)->make();
                $shortURL = $shortURLObject->default_short_url;

                $lastRecord = ShortUrls::latest()->first();
                if ($lastRecord) {
                    // Update the last record
                    $lastRecord->update([
                        'user_id' => Auth::id()
                    ]);
                }
                return response()->json(['data'=>'Success']);
               // return back()->with('message', 'Successffully created the short URL');
            } else {
                return response()->json(['data'=>'URL limit exceeded']);
                
            }
        } catch (\Exception $e) {
            return back()->with('error', ['errorMessage' => $e->getMessage()]);
        }
    }

    public function showDataTable()
    {
      //where('user_id', Auth::id())
        $data =  ShortUrls::where('user_id',Auth::id())->get();
        return view('urlShortnerList', ['data' => $data]);
    }

    public function deleteURL($id)
    {
       
        try {
            ShortUrls::find($id)->delete();
            Session::flash('success', 'Operation was successful!');
            return back();

        } catch (\Exception $th) {
            Session::flash('error', $th);
            return back();
        }
    }

    public function editURLForm($id, Request $request){
        
        $data =  ShortUrls::where('id', $id)->first();

        return view("urlShortnerForm")->with('data', $data);


    }
    public function updateURLForm($id, Request $request){   
            try {
                ShortUrls::find($id)->update($request->all());
            }   catch (\Exception $th) {    
            }
    }
}
