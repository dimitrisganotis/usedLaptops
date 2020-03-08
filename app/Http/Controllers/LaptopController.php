<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\{ User, Laptop };
use Auth;
use Psy\Util\Json;
use Response;

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
        $title = 'Browse Laptops';
        $laptops = empty($request->all()) ? Laptop::all() : Laptop::select('*');
        // $brands = Laptop::distinct()->pluck('brand');
        $brands = json_decode(Storage::get('brands.json'), true);

        if( empty($request->all()) ) {
            return view('laptops.index', [
                'title' => $title,
                'laptops' => $laptops,
                'brands' => $brands
            ]);
        } else {
            foreach( $request->all() as $key => $value ) {
                $laptops->where($key, $value);
            }

            return view('laptops.index', [
                'title' => $title,
                'laptops' => $laptops->get(),
                'brands' => $brands,
            ]);
        }
    }

    public function create()
    {
        $title = 'Post Laptop';
        $brands = json_decode(Storage::get('brands.json'), true);

        return view('laptops.create', [
            'title' => $title,
            'brands' => $brands,
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
