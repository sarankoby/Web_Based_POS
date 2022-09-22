<?php
namespace App\Http\Livewire;
use App\Models\Item as ItemModel;
use App\Models\Category as CategoryModel;
use App\Models\Brand as BrandModel;
use App\Models\Measurement as MeasurementModel;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Route;
class Item extends Component
{
    public $page_action=[];

    //public variables basic
    public $list_data = [];


    public $searchKey;
    public $key = 0;
    public $message = "";


    //new variable data management
    public $new_item;
    public $new_category;
    public $new_brand;
    public $new_measure;
    public $new_measurement;

     // for dropwdon
     public $categories = [];
     public $brands = [];
     public $measurements = [];

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
            $item = ItemModel::find($this->delete_id);
            $item->delete();
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
       #load data
       $this->categories = CategoryModel::latest()->get();

       # all records find brand
       $this->brands = BrandModel::latest()->get();

       #all record find measurements
       $this->measurements = MeasurementModel::latest()->get();

        #if search active
        if (!$this->searchKey) {
            $this->list_data = DB::table('items')
            ->select('items.*','categories.category as category_name','brands.brand as brand_name','measurements.measurement as measurement_name')
            ->join('categories','categories.id','=','items.category_id')
            ->join('brands','brands.id','=','items.brand_id')
            ->join('measurements','measurements.id','=','items.measurement_id')
            ->latest()
            ->take(10)
            ->get();
        } else {
            $this->list_data = DB::table('items')
            ->select('items.*','categories.category as category_name','brands.brand as brand_name','measurements.measurement as measurement_name')
            ->join('categories','categories.id','=','items.category_id')
            ->join('brands','brands.id','=','items.brand_id')
            ->join('measurements','measurements.id','=','items.measurement_id')
            ->where('items.item_name', 'LIKE', "%{$this->searchKey}%")
            ->latest()
            ->take(10)
            ->get();
        }
    }

    // insert and update data here
    public function saveData()
    {
        # validation
        $this->validate(
            [
                'new_item'=>'required',
                'new_measure'=>'required',
                'new_category'=>'required',
                'new_brand'=>'required',
                'new_measurement'=>'required'
            ]
        );

        if($this->key==0){
        #create
        $data=new ItemModel();
        $data->category_id=$this->new_category;
        $data->brand_id=$this->new_brand;
        $data->measurement_id=$this->new_measurement;
        $data->item_name=$this->new_item;
        $data->measure=$this->new_measure;
        $data->save();
        session()->flash('message', 'Item successfully Created!.');
        }else{
            //update
            $data=ItemModel::find($this->key);
            $data->category_id=$this->new_category;
            $data->brand_id=$this->new_brand;
            $data->measurement_id=$this->new_measurement;
            $data->item_name=$this->new_item;
            $data->measure=$this->new_measure;
            $data->save();
            session()->flash('message', 'Item successfully Updated!.');
        }
            //clear data
            $this->clearData();

    }

    //fill box forupdate
    public function updateRecord($id)
    {
        # code...
        $this->openModel();
        $item = ItemModel::find($id);
        $this->new_brand=$item->brand_id;
        $this->new_category=$item->category_id;
        $this->new_measurement=$item->measurement_id;
        $this->new_measure=$item->measure;
        $this->new_item=$item->item_name;
        $this->key=$id;
    }

    //clear data
    public function clearData()
    {
        # emty field
        $this->new_item="";
        $this->new_measure="";
        $this->key=0;
    }


    #comon controls
    public function pageAction()
    {
        # code...
        $x = Route::currentRouteName();
        $data = DB::table('access_points')
        ->select('access_points.access_model_id','access_points.id as access_point','access_points.value', 'access_models.access_model')
        ->join('access_models', 'access_points.access_model_id', '=', 'access_models.id')
        ->where('access_models.access_model', '=',$x)
        ->get();

       $access = session()->get('Access');
       for( $i=0; $i<sizeof($data); $i++ ){
            if(in_array($data[$i]->access_point,$access )){
                array_push($this->page_action,$data[$i]->value);
            }
        }
    }

    public function render()
    {
        $this->fetchData();
        $this->pageAction();
        return view('livewire.item')->layout('layouts.master');
    }
}
