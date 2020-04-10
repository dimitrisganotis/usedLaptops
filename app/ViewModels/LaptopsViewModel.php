<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use App\Laptop;

class LaptopsViewModel extends ViewModel
{
    public $laptop;
    public $hiddenLaptopAttributesFromTable = ['id', 'user_id', 'description', 'views', 'damage', 'price', 'created_at', 'updated_at'];

    public function __construct(Laptop $laptop)
    {
        $this->laptop = $laptop;
    }

    public function title()
    {
        return $this->laptop->brand . ' ' . $this->laptop->model . ($this->laptop->year ? ' (' . $this->laptop->year . ') ' : '');
    }

    public function diffFromNow()
    {
        $updatedAt = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $this->laptop->updated_at);
        $now = \Carbon\Carbon::now();

        if( $updatedAt->diffInMinutes($now) < 60 ) {
            return $updatedAt->diffInMinutes($now) <= 1 ? 'Now' : $updatedAt->diffInMinutes($now).' mins ago';
        } else if(  $updatedAt->diffInHours($now) < 24 ) {
            return $updatedAt->diffInHours($now) <= 1 ? 'An hour ago' : $updatedAt->diffInHours($now).' hours ago';
        } else if(  $updatedAt->diffInDays($now) < 7 ) {
            return $updatedAt->diffInDays($now) <= 1 ? 'A day ago' : $updatedAt->diffInDays($now).' days ago';
        } else {
            return $updatedAt->format('jS \\of F Y');
        }
    }

    public function storage()
    {
        return json_decode($this->laptop->storage, true);
    }
}
