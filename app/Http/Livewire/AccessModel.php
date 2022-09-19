<?php
namespace App\Http\Livewire;
use App\Models\AccessModel as AccessDataModel;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Route;
class AccessModel extends Component
{
    public $page_action=[];
    //public variables basic
    public $list_data = [];

    public $searchKey;
    public $key = 0;
    public $message = "";


    //new variable data management
    public $new_access_model = "";

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
            $access_model = AccessDataModel::find($this->delete_id);
            $access_model->delete();
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
            $this->list_data = DB::table('access_models')
                ->select('access_models.*')
                ->latest()
                ->take(15)
                ->get();
        } else {
            $this->list_data = DB::table('access_models')
                ->select('access_models.*')
                ->where('access_models.access_model', 'LIKE', '%' . $this->searchKey . '%')
                ->latest()
                ->take(5)
                ->get();
        }
    }

    // insert and update data here
    public function saveData()
    {
        //validate data
        $this->validate(
            [
                'new_access_model' => 'required|max:255|unique:access_models,access_model'

            ]
        );

        //check id value and execute
        if ($this->key == 0) {
            //here insert data
            $data = new AccessDataModel();
            $data->access_model = $this->new_access_model;
            $data->save();

            //show success message
            session()->flash('message', 'Saved Successfully!');

            //clear data
            $this->clearData();
        } else {
            //here update data
            $data = AccessDataModel::find($this->key);
            $data->access_model = $this->new_access_model;
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
        $data = AccessDataModel::find($id);
        $this->new_access_model = $data->access_model;
        $this->key = $id;
    }

    //clear data
    public function clearData()
    {
        # emty field
        $this->key = 0;
        $this->new_access_model = "";
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
        // return dd($this->list_data);
        //display records
        $this->pageAction();

        return view('livewire.access-model')->layout('layouts.master');
    }
}
