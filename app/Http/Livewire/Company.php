<?php
namespace App\Http\Livewire;
use App\Models\Company as CompanyModel;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Route;

class Company extends Component
{
    public $page_action = [];
    //public variables basic
    public $list_data = [];

    public $searchKey;
    public $key = 0;
    public $message = "";
    public $new_contact;
    public $new_email;
    public $new_description;

    //new variable data management
    public $new_name = "";

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
            $category = CompanyModel::find($this->delete_id);
            $category->delete();
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
            $this->list_data = DB::table('companies')
                ->select('companies.*')
                ->latest()
                ->take(15)
                ->get();
        } else {
            $this->list_data = DB::table('companies')
                ->select('companies.*')
                ->where('companies.company_name', 'LIKE', '%' . $this->searchKey . '%')
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
                'new_name' => 'required|max:255',
                'new_contact' => 'required|max:255',
                'new_email' => 'required|max:255|unique:companies,email'

            ]
        );

        //check id value and execute
        if ($this->key == 0) {
            //here insert data
            $data = new CompanyModel();
            $data->company_name = $this->new_name;
            $data->tp = $this->new_contact;
            $data->email = $this->new_email;
            $data->description = $this->new_description;
            $data->save();

            //show success message
            session()->flash('message', 'Saved Successfully!');

            //clear data
            $this->clearData();
        } else {
            //here update data
            $data = CompanyModel::find($this->key);
            $data->company_name = $this->new_name;
            $data->tp = $this->new_contact;
            $data->email = $this->new_email;
            $data->description = $this->new_description;
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
        $data = CompanyModel::find($id);
        $this->new_name =$data->company_name;
        $this->new_contact =$data->tp;
        $this->new_email = $data->email;
        $this->new_description =$data->description;
        $this->key = $id;
    }

    //clear data
    public function clearData()
    {
        # emty field
        $this->key = 0;
        $this->new_name = "";
        $this->new_contact = "";
        $this->new_description = "";
        $this->new_email = "";
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
        return view('livewire.company')->layout('layouts.master');
    }
}
