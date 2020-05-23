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
        $laptops = Laptop::select('*');
        // $brands = Laptop::distinct()->pluck('brand');
        $brands = json_decode(Storage::get('brands.json'));

        //dd($request->all());

        if(!empty($request->all())) {
            foreach($request->only(['brand', 'cpuBrand', 'os']) as $key => $value) {
                if(empty($value))
                    continue;

                if(is_array($value)) {
                    $laptops->whereIn($key, $value);
                    continue;
                }

                $laptops->where($key, $value);
            }

            if(!empty($request->search)) {
                $laptops->where('model', 'like', '%'.$request->search.'%');
                $laptops->orWhere('year', 'like', '%'.$request->search.'%');
                $laptops->orWhere('cpuModel', 'like', '%'.$request->search.'%');
            }
        }

        switch($request->sort) {
            case 'latest':
                $laptops->latest();
                break;
            case 'oldest':
                $laptops->oldest();
                break;
            default:
                $laptops->latest();
                break;
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
        $brands = json_decode(Storage::get('brands.json'));

        return view('laptops.create', compact(['title', 'brands']));
    }

    public function store(StoreLaptop $request)
    {
        $validatedInputs = $request->validated();

        if($file = $request->file('photo')) {
            $validatedInputs['photo'] = $file->store('public/uploads');
        }

        Laptop::create($validatedInputs);

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

        $validatedInputs = $request->validated();

        if($file = $request->file('photo')) {
            $laptop->photo ? Storage::delete($laptop->photo) : null;
            $validatedInputs['photo'] = $file->store('public/uploads');
        }

        $laptop->update($validatedInputs);

        return redirect('/laptops/'.$laptop->id)->with('status', 'Laptop updated!');
    }

    public function destroy(Laptop $laptop)
    {
        if($laptop->user->id != Auth::id())
            abort(403, 'Unauthorized action.');

        $laptop->photo ? Storage::delete($laptop->photo) : null;
        Laptop::destroy($laptop->id);

        return redirect('/laptops')->with('status', 'Laptop deleted!');
    }
}
