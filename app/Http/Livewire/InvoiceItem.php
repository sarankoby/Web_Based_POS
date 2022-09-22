<?php

namespace App\Http\Livewire;

use App\Models\Brand as BrandModel;
use App\Models\Category as CategoryModel;
use App\Models\InvoiceItem as InvoiceModel;
use Carbon\Carbon;
use DNS1D;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Route;

class InvoiceItem extends Component
{
    public $page_action = [];
    //public variables basic
    public $list_data = [];
    public $purchase_invoice = [];
    public $categories = [];
    public $brands = [];
    public $invoice_items = [];

    public $searchKey;
    public $key = 0;
    public $message = "";


    //new variable data management
    public $purchase_id;
    public $new_expiry;
    public $new_min_sell;
    public $new_sell;
    public $new_buy;
    public $new_quantity;
    public $new_item;
    public $new_mfd_date;

    # filter
    public $select_category = 0;
    public $select_brand = 0;


    //mount function inital call
    public function mount($id)
    {
        $this->purchase_id = $id;
    }


    //open model insert
    public function openModel()
    {
        $this->dispatchBrowserEvent('insert-show-form');
    }

    //close model insert
    public function closeModel()
    {
        $this->dispatchBrowserEvent('insert-hide-form');
    }

    //open model delete
    public $delete_id = 0;
    public function deleteOpenModel($id)
    {
        $this->delete_id = $id;
        $this->dispatchBrowserEvent('delete-show-form');
    }

    #delete Data
    public function deleteRecord()
    {
        # code...
        if ($this->delete_id != 0) {
            $delear = InvoiceModel::find($this->delete_id);
            $delear->delete();
            $this->deleteCloseModel();
        }
    }

    //close model close
    public function deleteCloseModel()
    {
        $this->dispatchBrowserEvent('delete-hide-form');
    }

    //load data
    //load data
    public function loadData()
    {
        # fetch data from database
        if ($this->select_brand == 0 && $this->select_category == 0) {
            #all item show
            $this->items = DB::table('items')
                ->select('items.*', 'categories.category as category_name', 'brands.brand as brand_name', 'measurements.measurement as measurement_name')
                ->join('categories', 'categories.id', '=', 'items.category_id')
                ->join('brands', 'brands.id', '=', 'items.brand_id')
                ->join('measurements', 'measurements.id', '=', 'items.measurement_id')
                ->latest()
                ->get();
        } elseif ($this->select_brand != 0) {
            $this->items = DB::table('items')
                ->select('items.*', 'categories.category as category_name', 'brands.brand as brand_name', 'measurements.measurement as measurement_name')
                ->join('categories', 'categories.id', '=', 'items.category_id')
                ->join('brands', 'brands.id', '=', 'items.brand_id')
                ->join('measurements', 'measurements.id', '=', 'items.measurement_id')
                ->where('brands.id', '=', $this->select_brand)
                ->latest()
                ->get();
        } elseif ($this->select_category != 0) {
            $this->items = DB::table('items')
                ->select('items.*', 'categories.category as category_name', 'brands.brand as brand_name', 'measurements.measurement as measurement_name')
                ->join('categories', 'categories.id', '=', 'items.category_id')
                ->join('brands', 'brands.id', '=', 'items.brand_id')
                ->join('measurements', 'measurements.id', '=', 'items.measurement_id')
                ->where('categories.id', '=', $this->select_category)
                ->latest()
                ->get();
        } else {
            $this->items = DB::table('items')
                ->select('items.*', 'categories.category as category_name', 'brands.brand as brand_name', 'measurements.measurement as measurement_name')
                ->join('categories', 'categories.id', '=', 'items.category_id')
                ->join('brands', 'brands.id', '=', 'items.brand_id')
                ->join('measurements', 'measurements.id', '=', 'items.measurement_id')
                ->where('categories.id', '=', $this->select_category)
                ->where('brands.id', '=', $this->select_brand)
                ->latest()
                ->get();
        }
    }

    //fetch data from db
    public function fetchData()
    {
        $this->categories = CategoryModel::all();
        $this->brands = BrandModel::all();

        #fetch company details
        $this->purchase_invoice = DB::table('purchase_invoices')
            ->select('purchase_invoices.*', 'companies.company_name', 'dealers.name as dealer_name')
            ->join('companies', 'companies.id', '=', 'purchase_invoices.company_id')
            ->join('dealers', 'dealers.id', '=', 'purchase_invoices.dealer_id')
            ->where('purchase_invoices.id', '=', $this->purchase_id)
            ->latest()
            ->get();


        #if search active
        if (!$this->searchKey) {
            $this->list_data = DB::table('invoice_items')
                ->select('invoice_items.*', 'items.item_name', 'items.measure', 'categories.category as category_name', 'brands.brand as brand_name', 'measurements.measurement as measurement_name')
                ->join('items', 'items.id', '=', 'invoice_items.item_id')
                ->join('categories', 'categories.id', '=', 'items.category_id')
                ->join('brands', 'brands.id', '=', 'items.brand_id')
                ->join('measurements', 'measurements.id', '=', 'items.measurement_id')
                ->where('invoice_items.invoice_id', '=', $this->purchase_id)
                ->latest()
                ->get();
        } else {
            $this->list_data = DB::table('invoice_items')
                ->select('invoice_items.*', 'items.item_name', 'items.measure', 'categories.category as category_name', 'brands.brand as brand_name', 'measurements.measurement as measurement_name')
                ->join('items', 'items.id', '=', 'invoice_items.item_id')
                ->join('categories', 'categories.id', '=', 'items.category_id')
                ->join('brands', 'brands.id', '=', 'items.brand_id')
                ->join('measurements', 'measurements.id', '=', 'items.measurement_id')
                ->where('invoice_items.invoice_id', '=', $this->purchase_id)
                ->where('invoice_items.barcode', 'LIKE', "%{$this->searchKey}%")
                ->latest()
                ->get();
        }
    }

    // insert and update data here
    public function saveData()
    {
        //validate data
        $this->validate(
            [
                'new_item' => 'required',
                'new_quantity' => 'required|min:1',
                'new_buy' => 'required|min:1',
                'new_sell' => 'required|min:1',
                'new_min_sell' => 'required|min:1',
                'new_expiry' => 'required|after:today',
                'new_mfd_date' => 'required|before:today',

            ]
        );

        //check id value and execute
        if ($this->key == 0) {
            //here insert data
            $data = new InvoiceModel();
            $bar = (Carbon::now()->timestamp) - 1600000000;

            $data->quantity = $this->new_quantity;
            $data->buy_quantity = $this->new_quantity;
            $data->sell = $this->new_sell;
            $data->buy = $this->new_buy;
            $data->min_sell = $this->new_min_sell;
            $data->expiry = $this->new_expiry;
            $data->mfd=$this->new_mfd_date;
            $data->barcode = $bar;
            $data->item_id = $this->new_item;
            $data->invoice_id = $this->purchase_id;
            $data->save();

            \Storage::disk('public')->put($bar.'.png', base64_decode(DNS1D::getBarcodePNG($bar, "I25")));



            //show success message
            session()->flash('message', 'Saved Successfully!');

            //clear data
            $this->clearData();
        } else {
            //here update data
            $data = InvoiceModel::find($this->key);
            $data->quantity=$this->new_quantity;
            $data->buy_quantity = $this->new_quantity;
            $data->sell=$this->new_sell;
            $data->buy=$this->new_buy;
            $data->min_sell=$this->new_min_sell;
            $data->expiry=$this->new_expiry;
            $data->mfd=$this->new_mfd_date;
            $data->item_id=$this->new_item;
            $data->invoice_id=$this->purchase_id;
            $data->save();

            //show success message
            session()->flash('message', ' Update Successfuly!');

            //clear data
            $this->clearData();
        }
    }

    //fill box forupdate
    public function updateRecord($id)
    {
        # code...
        $this->openModel();
        $item = InvoiceModel::find($id);
        $this->new_item = $item->item_id;
        $this->new_expiry = $item->expiry;
        $this->new_mfd_date = $item->mfd;
        $this->key = $id;
        $this->new_min_sell = $item->min_sell;
        $this->new_sell = $item->sell;
        $this->new_buy = $item->buy;
        $this->new_quantity = $item->quantity;
        $this->key = $id;
    }

    //clear data
    public function clearData()
    {
        # emty field
        $this->key = 0;
        $this->new_item=0;
        $this->new_expiry="";
        $this->new_mfd_date="";
        $this->key=0;
        $this->new_min_sell="";
        $this->new_sell="";
        $this->new_buy="";
        $this->new_quantity="";
    }


    #comon controls
    public function pageAction()
    {
        # code...
        $x = Route::currentRouteName();
        $data = DB::table('access_points')
            ->select('access_points.access_model_id', 'access_points.id as access_point', 'access_points.value', 'access_models.access_model')
            ->join('access_models', 'access_points.access_model_id', '=', 'access_models.id')
            ->where('access_models.access_model', '=', $x)
            ->get();

        $access = session()->get('Access');
        for ($i = 0; $i < sizeof($data); $i++) {
            if (in_array($data[$i]->access_point, $access)) {
                array_push($this->page_action, $data[$i]->value);
            }
        }
    }

    public function render()
    {
        $this->loadData();
        $this->fetchData();
        $this->pageAction();
        return view('livewire.invoice-item')->layout('layouts.master');
    }
}
