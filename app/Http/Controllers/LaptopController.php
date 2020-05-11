<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\ViewModels\LaptopsViewModel;
use App\Http\Requests\StoreLaptop;
use App\{ User, Laptop };
use Auth;

class LaptopController extends Controller
{
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
        $brands = json_decode(Storage::get('brands.json'));

        if( !empty($request->all()) ) {
            if( !$request->input('page') || ( $request->input('page') && count($request->all()) > 1 ) ) {
                foreach( $request->all() as $key => $value ) {
                    $laptops->where($key, $value);
                }
            }
        }

        return view('laptops.index', [
            'title' => $title,
            'laptops' => $laptops->latest()->paginate(6),
            'brands' => $brands
        ]);
    }

    public function create()
    {
        $title = 'Post Laptop';
        $brands = json_decode(Storage::get('brands.json'));

        return view('laptops.create', compact(['title', 'brands']));
    }

    public function store(StoreLaptop $request)
    {
        Laptop::create($request->validated());

        return redirect('/laptops')->with('status', 'Laptop added!');
    }

    public function show(Laptop $laptop)
    {
        $laptop->timestamps = false;
        $laptop->increment('views');
        $laptop->timestamps = true;

        return view('laptops.show', new LaptopsViewModel($laptop));
    }

    public function edit(Laptop $laptop)
    {
        if($laptop->user->id != Auth::id())
            abort(403, 'Unauthorized action.');

        $title = 'Edit Laptop';
        $brands = json_decode(Storage::get('brands.json'));

        return view('laptops.edit', compact(['title', 'brands', 'laptop']));
    }

    public function update(StoreLaptop $request, Laptop $laptop)
    {
        if($laptop->user->id != Auth::id())
            abort(403, 'Unauthorized action.');

        $laptop->update($request->validated());

        return redirect('/laptops/'.$laptop->id)->with('status', 'Laptop updated!');
    }

    public function destroy(Laptop $laptop)
    {
        if($laptop->user->id != Auth::id())
            abort(403, 'Unauthorized action.');

        Laptop::destroy($laptop->id);

        return redirect('/laptops')->with('status', 'Laptop deleted!');
    }
}
