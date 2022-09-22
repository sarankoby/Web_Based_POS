<?php

namespace App\Http\Livewire;

use App\Models\BranchStore as BranchStoreModel;
use App\Models\InvoiceItem as InvoiceItemModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Route;

class StockTransfer extends Component
{
    public $page_action = [];
    //public variables basic
    public $list_data = [];

    public $branch_data = [];

    public $searchKey;
    public $key = 0;
    public $message = "";

    public $tab=1;
    //new variable data management
    public $new_brand = "";

    public $new_main_quantity = 0;
    public $new_branch_quantity = 0;

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



    //close model close
    public function deleteCloseModel()
    {
        $this->dispatchBrowserEvent('delete-hide-form');
    }

    public function searchClear()
    {
        # code...
        $this->searchKey="";
        $this->dispatchBrowserEvent('change-focus-other-field');
    }



    //fetch data from db
    public function fetchData()
    {
        #if search active
        if ($this->searchKey) {
            $this->list_data = DB::table('invoice_items')
                ->select('invoice_items.*', 'items.item_name', 'items.measure', 'categories.category as category_name', 'brands.brand as brand_name', 'measurements.measurement as measurement_name')
                ->join('items', 'items.id', '=', 'invoice_items.item_id')
                ->join('categories', 'categories.id', '=', 'items.category_id')
                ->join('brands', 'brands.id', '=', 'items.brand_id')
                ->join('measurements', 'measurements.id', '=', 'items.measurement_id')
                ->where('invoice_items.barcode', '=', $this->searchKey)
                ->latest()
                ->get();

            $this->branch_data = DB::table('branch_stores')
                ->select('branch_stores.*', 'invoice_items.barcode')
                ->join('invoice_items', 'invoice_items.id', '=', 'branch_stores.invoice_items_id')
                ->where('invoice_items.barcode', '=', $this->searchKey)
                ->get();
        }else{
            $this->list_data=[];
            $this->branch_data=[];
        }
    }

    // insert and update data here
    public function mainToBranchTransfer()
    {
        $this->fetchData();
        //validate data
        $this->validate(
            [
                'new_main_quantity' => 'required|numeric|min:1|max:' . ($this->list_data[0]->quantity)

            ]
        );

        //here update data
        if (sizeOf($this->branch_data) != 0) {

            //updte quantity in branch store
            $data = BranchStoreModel::find($this->branch_data[0]->id);
            $data->quantity = $data->quantity + $this->new_main_quantity;
            $data->invoice_items_id = $this->list_data[0]->id;
            $data->auth_id = Auth::user()->id;
            $data->save();

            //update main store balance
            $main = InvoiceItemModel::find($this->list_data[0]->id);
            $main->quantity = $main->quantity - $this->new_main_quantity;
            $main->save();

            //show success message
            session()->flash('main_message', ' Stock Transfered Successfuly!');
            //clear data
            $this->clearData();
        } else {
            //insert quantity in branch store
            $data = new BranchStoreModel();
            $data->quantity = $this->new_main_quantity;
            $data->invoice_items_id = $this->list_data[0]->id;
            $data->auth_id = Auth::user()->id;
            $data->save();

            $main = InvoiceItemModel::find($this->list_data[0]->id);
            $main->quantity = $main->quantity - $this->new_main_quantity;
            $main->save();

            //show success message
            session()->flash('main_message', ' Stock Transfered Successfuly!');
            //clear data
            $this->clearData();
        }


        $this->searchClear();

    }


    // insert and update data here
    public function branchToMainTransfer()
    {
        $this->fetchData();
        //validate data
        $this->validate(
            [
                'new_branch_quantity' => 'required|numeric|min:1|max:'.($this->branch_data[0]->quantity)

            ]
        );

        //here update data
        if (sizeOf($this->branch_data) != 0) {
            //update main store balance
            $main = InvoiceItemModel::find($this->list_data[0]->id);
            $main->quantity = $main->quantity + $this->new_branch_quantity;
            $main->save();

            //updte quantity in branch store
            $data = BranchStoreModel::find($this->branch_data[0]->id);
            $data->quantity = $data->quantity - $this->new_branch_quantity;
            $data->save();

            //show success message
            session()->flash('branch_message', ' Stock Transfered Successfuly!');
            //clear data
            $this->clearData();
        }
        $this->searchClear();
    }


    //clear data
    public function clearData()
    {
        # emty field
        $this->key = 0;
        $this-> new_main_quantity = 0;
        $this-> new_branch_quantity = 0;
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
        $this->fetchData();
        $this->pageAction();
        return view('livewire.stock-transfer')->layout('layouts.master');
    }
}
