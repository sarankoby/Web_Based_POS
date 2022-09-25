<?php
namespace App\Http\Livewire;
use App\Models\BranchStore as BranchStoreModel;
use App\Models\InvoiceItem as InvoiceItemModel;
use App\Models\TemOrder as TemOrderModel;
use App\Models\Customer as CustomerModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Route;

// require __DIR__ . 'vendor/autoload.php';

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;

class Sale extends Component
{
    public $page_action = [];
    //public variables basic
    public $list_data = [];

    public $branch_data = [];
    public $bill_item = [];

    public $searchKey;
    public $key = 0;
    public $message = "";

    public $tab = 1;
    //new variable data management
    public $new_brand = "";

    public $new_sel_quantity = 1;
    public $new_sel_price;

    public $new_branch_quantity = 0;


    public $active_panal = false;

    //call
    public $item_total = 0;
    //open model insert

    public $customers = [];
    public $customer_search;
    public $new_customer_id;
    public $customer_data;

    //new variable data management
    public $new_name = "";
    public $new_contact;


    public function textPrint()
    {
        // $profile = CapabilityProfile::load("SP2000");
        // $connector = new WindowsPrintConnector("POS-80-Series");
        // $printer = new Printer($connector, $profile);
        // // return dd($printer);
        // $printer->text("Hello World!\n",);
        // $printer->text("Hello World!\n");
        // $printer->text("Hello World!\n");
        // $printer->text("Hello World!\n");
        // $printer->cut();
        // $printer->close();
        // return dd("text click");

        $this->dispatchBrowserEvent('do-print');
    }


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


    public function activeView()
    {
        # code...
        $this->active_panal = !$this->active_panal;
    }


    //close model close
    public function deleteCloseModel()
    {
        $this->dispatchBrowserEvent('delete-hide-form');
    }

    public function searchClear()
    {
        # code...
        $this->searchKey = "";
        $this->dispatchBrowserEvent('change-focus-other-field');
    }

    #customer function
    public function selectedCustomer()
    {
        # code...
        if ($this->new_customer_id != 0) {
            $this->customer_data = CustomerModel::find($this->new_customer_id);
        } else {
            $this->customer_data = null;
        }
    }


    //fetch data from db
    public function fetchData()
    {
        # add item data

        $this->bill_item = DB::table('tem_orders')
            ->select('tem_orders.*', 'items.item_name', 'items.measure', 'categories.category as category_name', 'brands.brand as brand_name', 'measurements.measurement as measurement_name')
            ->join('invoice_items', 'tem_orders.invoice_items_id', '=', 'invoice_items.id')
            ->join('items', 'items.id', '=', 'invoice_items.item_id')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->join('brands', 'brands.id', '=', 'items.brand_id')
            ->join('measurements', 'measurements.id', '=', 'items.measurement_id')
            ->where('tem_orders.auth_id', '=', Auth::user()->id)
            ->latest()
            ->get();

        $item_total = 0;
        foreach ($this->bill_item as $row) {
            $item_total =  $item_total + ($row->quantity * $row->amount);
        }
        $this->item_total = $item_total;

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

            if (sizeof($this->list_data) != 0) {
                $this->new_sel_price = $this->list_data[0]->sell;
            }
        } else {
            $this->list_data = [];
            $this->branch_data = [];
        }
    }

    public function customerFind()
    {
        # code...
        if ($this->customer_search) {
            $this->customers = CustomerModel::where('customer_name', 'LIKE', "%{$this->customer_search}%")
                ->orWhere('tp', 'LIKE', "%{$this->customer_search}%")
                ->get();

            if (sizeof($this->customers) == 1) {
                $this->new_customer_id = $this->customers[0]->id;
                $this->selectedCustomer();
            }
        } else {
            $this->customers = CustomerModel::all();
        }
    }

    // insert and update data here
    public function saveData()
    {
        //validate data
        $this->validate(
            [
                'new_name' => 'required|max:255',
                'new_contact' => 'required|max:255|unique:customers,tp'

            ]
        );
        // $bar = (Carbon::now()->timestamp) - 1600000000;
        //here insert data
        $data = new CustomerModel();
        $data->customer_name = $this->new_name;
        $data->tp = $this->new_contact;
        // $data->code=$bar;
        $data->save();


        $this->customer_search = $this->new_contact;
        // \Storage::disk('public')->put($bar.'.png', base64_decode(DNS1D::getBarcodePNG($bar, "I25")));
        //show success message
        session()->flash('message', 'Saved Successfully!');
        //clear data
        $this->clearData();
    }



    // insert and update data here
    public function addToTemBIll()
    {
        $this->fetchData();
        //here update data
        if (sizeOf($this->branch_data) != 0) {
            //validate data
            $this->validate(
                [
                    'new_sel_quantity' => 'required|numeric|min:1|max:' . ($this->branch_data[0]->quantity),
                    'new_sel_price' => 'required|numeric|min:' . ($this->list_data[0]->min_sell)

                ]
            );
            // check orderl olredy exit
            $tem_order = DB::table('tem_orders')->select('tem_orders.*')->where('tem_orders.invoice_items_id', '=', $this->branch_data[0]->invoice_items_id)->where('auth_id', '=', Auth::user()->id)->get();
            if (sizeof($tem_order) != 0) {
                // update tem order data
                $temdata = TemOrderModel::find($tem_order[0]->id);
                $temdata->quantity = $temdata->quantity + $this->new_sel_quantity;
                $temdata->amount = $this->new_sel_price;
                $temdata->discount = $this->list_data[0]->sell - $this->new_sel_price;
                $temdata->save();

                //updte quantity in branch store when sale
                $data = BranchStoreModel::find($this->branch_data[0]->id);
                $data->quantity = $data->quantity - $this->new_sel_quantity;
                $data->save();
            } else {

                // insert tem oreder data
                $temdata = new TemOrderModel();
                $temdata->quantity = $temdata->quantity + $this->new_sel_quantity;
                $temdata->amount = $this->new_sel_price;
                $temdata->discount = $this->list_data[0]->sell - $this->new_sel_price;
                $temdata->invoice_items_id = $this->branch_data[0]->invoice_items_id;
                $temdata->auth_id = Auth::user()->id;
                $temdata->save();

                //updte quantity in branch store when sale
                $data = BranchStoreModel::find($this->branch_data[0]->id);
                $data->quantity = $data->quantity - $this->new_sel_quantity;
                $data->save();
            }
            //show success message
            session()->flash('main_message', 'Item(s) Added Successfuly!');
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
                'new_branch_quantity' => 'required|numeric|min:1|max:' . ($this->branch_data[0]->quantity)

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

    #delete Data
    public function deleteRecord()
    {
        # code...
        if ($this->delete_id != 0) {
            $delete_data = TemOrderModel::find($this->delete_id);
            //find branch store
            $branch_item = BranchStoreModel::where('invoice_items_id', '=', $delete_data->invoice_items_id)->first();
            $branch_item->quantity = $branch_item->quantity + $delete_data->quantity;
            $branch_item->save();

            $delete_data->delete();
            $this->deleteCloseModel();
        }
    }

    //clear data
    public function clearData()
    {
        # emty field
        $this->key = 0;
        $this->new_sel_quantity = 1;
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
        $this->customerFind();
        return view('livewire.sale')->layout('layouts.master');
    }
}
