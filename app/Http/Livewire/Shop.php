<?php

namespace App\Http\Livewire;

use App\Models\Shop as ShopModel;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Route;
// use Carbon\Carbon;
// use DNS1D;
class Shop extends Component
{
    public $page_action = [];
    //public variables basic
    public $list_data = [];

    public $searchKey;
    public $key = 0;
    public $message = "";

    //new variable data management
    public $new_name = "";
    public $new_contact;

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
            $data = ShopModel::find($this->delete_id);
            $data->delete();
            $this->deleteCloseModel();
        }
    }

    //close model close
    public function deleteCloseModel()
    {
        $this->dispatchBrowserEvent('delete-hide-form');
    }

    //fetch data from db
    public function fetchData()
    {
        #if search active
        if (!$this->searchKey) {
            $this->list_data = DB::table('shops')
                ->select('shops.*')
                ->latest()
                ->take(15)
                ->get();
        } else {
            $this->list_data = DB::table('shops')
                ->select('shops.*')
                ->where('shops.shop_name', 'LIKE', '%' . $this->searchKey . '%')
                ->orWhere('shops.tp', 'LIKE', '%' . $this->searchKey . '%')
                ->latest()
                ->take(5)
                ->get();
        }
    }

    // insert and update data here
    public function saveData()
    {

        //check id value and execute
        if ($this->key == 0) {

            //validate data
            $this->validate(
                [
                    'new_name' => 'required|max:255',
                    'new_contact' => 'required|max:255|unique:shops,tp'

                ]
            );
            // $bar = (Carbon::now()->timestamp) - 1600000000;
            //here insert data
            $data = new ShopModel();
            $data->shop_name = $this->new_name;
            $data->tp = $this->new_contact;
            // $data->code=$bar;
            $data->save();

            // \Storage::disk('public')->put($bar.'.png', base64_decode(DNS1D::getBarcodePNG($bar, "I25")));
            //show success message
            session()->flash('message', 'Saved Successfully!');

            //clear data
            $this->clearData();
        } else {
            //here update data
            $data = ShopModel::find($this->key);
            //validate data
            $this->validate(
                [
                    'new_name' => 'required|max:255',
                    'new_contact' => 'required|max:255|unique:shops,tp,' . $data->id

                ]
            );

            $data->shop_name = $this->new_name;
            $data->tp = $this->new_contact;
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
        $data = ShopModel::find($id);
        $this->new_name = $data->shop_name;
        $this->new_contact = $data->tp;
        $this->key = $id;
    }

    //clear data
    public function clearData()
    {
        # emty field
        $this->key = 0;
        $this->new_name = "";
        $this->new_contact = "";
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
        return view('livewire.shop')->layout('layouts.master');
    }

    public function printRecepit()
    {
        # code...
        // $text = (string) (new ReceiptPrinter)
        //     ->centerAlign()
        //     ->text('My heading')
        //     ->leftAlign()
        //     ->line()
        //     ->twoColumnText('Item 1', '2.00')
        //     ->twoColumnText('Item 2', '4.00')
        //     ->feed(2)
        //     ->centerAlign()
        //     ->barcode('1234')
        //     ->cut();

        // Printing::newPrintTask()
        //     ->printer($printerId)
        //     ->content($text) // content will be base64_encoded if using PrintNode
        //     ->send();
    }
}
