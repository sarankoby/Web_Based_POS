<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\DB;
use App\Models\Customer as CustomerModel;
use Carbon\Carbon;
use Livewire\Component;
use Route;


class Dashboard extends Component
{

    public $new_name;
    public $customers = [];
    public $purchase_invoices = [];
    public $branch_stores = [];
    public $expenses = [];
    public $dealers = [];
    public $shops = [];
    public $time = [];



    
    public function openModel()
    {
        # code...
        $this->dispatchBrowserEvent('show-form');
    }
    public function render()
    {


        $this->customers = DB::table('customers')->count();
        $this->purchase_invoices = DB::table('purchase_invoices')->sum('amount');
        $this->branch_stores = DB::table('branch_stores')->count();
        $this->expenses = DB::table('expences')->sum('amount');
        $this->dealers = DB::table('dealers')->count();
        $this->shops = DB::table('shops')->count();


        $this->time = Carbon::now();

        return view('livewire.dashboard')->layout('layouts.master');
    }
}
