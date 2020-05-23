<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use App\Laptop;

class LaptopsViewModel extends ViewModel
{
    public $laptop;
    public $hiddenLaptopAttributesFromTable = ['id', 'user_id', 'description', 'storage1', 'storage2', 'views', 'damage', 'price', 'photo', 'created_at', 'updated_at'];

    public function __construct(Laptop $laptop)
    {
        $this->laptop = $laptop;
    }

    public function title()
    {
        return $this->laptop->brand . ' ' . $this->laptop->model . ($this->laptop->year ? ' (' . $this->laptop->year . ') ' : '');
    }

    public function photo()
    {
        return $this->laptop->photo ? str_replace('public', 'storage', $this->laptop->photo) : null;
    }

    public function storage()
    {
        //dd($this->laptop->storage1);
        return [
            $this->laptop->storage1,
            $this->laptop->storage2,
        ];
    }
}
