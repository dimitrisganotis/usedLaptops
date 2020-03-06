<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{ User, Laptop };
use Auth;
use Psy\Util\Json;
use Response;
use View;

class LaptopController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        if( empty($request->all()) ) {
            return view('laptops', [
                'title' => 'Browse Laptops',
                'laptops' => Laptop::all()
            ]);
        } else {
            $laptops = Laptop::select('*');

            foreach( $request->all() as $key => $value ) {
                $laptops->where($key, $value);
            }

            return view('laptops', [
                'title' => 'Browse Laptops',
                'laptops' => $laptops->get()
            ]);
        }
    }

    public function create()
    {
        return view('', [

        ]);
    }

    public function store(Request $request)
    {
        // factory(\App\User::class)->create();
        return Laptop::create([

        ]);
    }

    public function show(Laptop $laptop)
    {
        return response()->json(Laptop::find($laptop));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        Laptop::create([

        ]);
    }

    public function destroy($id)
    {
        /*$users = User::findOrFail($id);
        $users->delete();
        return Redirect::route('comics.users' , compact('users'));*/
    }
}
