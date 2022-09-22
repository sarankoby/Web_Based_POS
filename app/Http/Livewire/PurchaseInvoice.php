<?php
namespace App\Http\Livewire;
use App\Models\PurchaseInvoice as PurchaseInvoiceModel;
use App\Models\Company as CompanyModel;
use App\Models\Dealer as DealerModel;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Route;
class PurchaseInvoice extends Component
{
    public $page_action=[];
    //public variables basic
    public $list_data = [];

    public $searchKey;
    public $key = 0;
    public $message = "";


    //new variable data management
    public $companies = [];
    public $dealers = [];
    public $new_invoice_number;
    public $new_company;
    public $new_dealer;
    public $new_amount;
    public $new_description;
    public $new_date;
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
            $invoice = PurchaseInvoiceModel::find($this->delete_id);
            $invoice->delete();
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

        $this->companies = CompanyModel::all();
        $this->dealers = DealerModel::where('company_id', '=', $this->new_company)->get();

        #if search active
        if (!$this->searchKey) {
            $this->list_data = DB::table('purchase_invoices')
            ->select('purchase_invoices.*', 'companies.company_name', 'dealers.name as dealer_name')
            ->join('companies', 'purchase_invoices.company_id', '=', 'companies.id')
            ->join('dealers', 'dealers.id', '=', 'purchase_invoices.dealer_id')
            ->latest()
            ->take(5)
            ->get();
        } else {
            $this->list_data = DB::table('purchase_invoices')
            ->select('purchase_invoices.*', 'companies.company_name', 'dealers.name as dealer_name')
            ->join('companies', 'purchase_invoices.company_id', '=', 'companies.id')
            ->join('dealers', 'dealers.id', '=', 'purchase_invoices.dealer_id')
            ->where('purchase_invoices.invoice_number', 'LIKE', "%{$this->searchKey}%")
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
                'new_invoice_number' => 'required|max:255',
                'new_amount' => 'required',
                'new_date' => 'required'

            ]
        );

        //check id value and execute
        if ($this->key == 0) {
            //here insert data
            $data = new PurchaseInvoiceModel();
            $data->invoice_number = $this->new_invoice_number;
            $data->company_id = $this->new_company;
            $data->dealer_id = $this->new_dealer;
            $data->description = $this->new_description;
            $data->amount = $this->new_amount;
            $data->invoice_date = $this->new_date;
            $data->save();

            //show success message
            session()->flash('message', 'Saved Successfully!');

            //clear data
            $this->clearData();
        } else {
            //here update data
            $data = PurchaseInvoiceModel::find($this->key);
            $data->invoice_number = $this->new_invoice_number;
            $data->company_id = $this->new_company;
            $data->dealer_id = $this->new_dealer;
            $data->description = $this->new_description;
            $data->amount = $this->new_amount;
            $data->invoice_date = $this->new_date;
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
        $data = PurchaseInvoiceModel::find($id);
        $this->new_invoice_number = $data->invoice_number;
        $this->new_company = $data->company_id;
        $this->new_dealer = $data->dealer_id;
        $this->new_amount = $data->amount;
        $this->new_date = $data->invoice_date;
        $this->new_description = $data->description;
        $this->key = $id;
    }

    //clear data
    public function clearData()
    {
        # emty field
        $this->key = 0;
        $this->new_invoice_number = "";
        $this->new_company = 0;
        $this->new_dealer = 0;
        $this->new_description = "";
        $this->new_amount = "";
        $this->new_date = "";
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
        return view('livewire.purchase-invoice')->layout('layouts.master');
    }
}
