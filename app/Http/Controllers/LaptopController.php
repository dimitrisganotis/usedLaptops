<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\ViewModels\LaptopsViewModel;
use App\{ User, Laptop };
use Auth;

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
        //$laptops = empty($request->all()) ? Laptop::all() : Laptop::select('*');
        $laptops = Laptop::select('*');
        // $brands = Laptop::distinct()->pluck('brand');
        $brands = json_decode(Storage::get('brands.json'), true);

        if( !empty($request->all()) ) {
            if( !$request->input('page') || ( $request->input('page') && count($request->all()) > 1 ) ) {
                foreach( $request->all() as $key => $value ) {
                    $laptops->where($key, $value);
                }
            }
        }

        return view('laptops.index', [
            'title' => $title,
            'laptops' => $laptops->paginate(6),
            'brands' => $brands
        ]);
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
        //['id', 'user_id', 'description', 'views', 'created_at', 'updated_at']
        $laptop->timestamps = false;
        $laptop->increment('views');

        return view('laptops.show', new LaptopsViewModel($laptop));
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
