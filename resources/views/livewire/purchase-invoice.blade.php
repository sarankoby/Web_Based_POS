@push('purchase', 'active')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-primary text-white-all">
            <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#"><i class="far fa-file"></i>Purchase</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>Purchase-Invoice</li>
        </ol>
    </nav>

    <div class="row">

        <div class="col-12 col-md-4">

        </div>

        <div class="col-12 col-md-8">

            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" wire:model="searchKey" wire:keyup="fetchData"
                        placeholder="" aria-label="">
                    <div class="input-group-append">
                        <button class="btn btn-primary" wire:click="fetchData">Search</button>
                    </div>

                    @if (in_array('Save', $page_action))
                        <button id="formOpen" wire:click="openModel" class="btn btn-success ml-1"><i class="fa fa-plus"
                                aria-hidden="true"></i> Create-New
                        </button>
                    @endif

                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="p-4">
                    <h4>Purchase-Invoice(s)</h4>

                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tableExport">
                            <tr>
                                <th>#</th>
                                <th>Company</th>
                                <th>Dealer</th>
                                <th>Invoice-Number</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            @php($x = 1)
                            @foreach ($list_data as $row)
                                <tr>
                                    <td>{{ $x }}</td>
                                    <td>{{ $row->company_name }}</td>
                                    <td>{{ $row->dealer_name }}</td>
                                    <td>{{ $row->invoice_number }}</td>
                                    <td>{{ $row->amount }}</td>
                                    <td>{{ $row->description }}
                                        <br>
                                       <span class="text-secondary"> {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</span>
                                    </td>
                                    <td>{{ $row->invoice_date }}</td>
                                    <td>
                                        @if (in_array('Delete', $page_action))
                                            <a href="#" class="text-danger m-2"
                                                wire:click="deleteOpenModel({{ $row->id }})"><i class="fa fa-trash"
                                                    aria-hidden="true"></i>
                                            </a>
                                        @endif

                                        @if (in_array('Update', $page_action))
                                            <a href="#" class="text-info"
                                                wire:click="updateRecord({{ $row->id }})"><i class="fa fa-pen"
                                                    aria-hidden="true"></i>
                                            </a>
                                        @endif

                                        @if (in_array('Add-More', $page_action))
                                        <a href="/invoice-items/{{ $row->id }}" class="text-success">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @php($x++)
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>


        {{-- Insert model here --}}
        <div wire:ignore.self class="modal fade bd-example-modal-lg" id="insert-model" tabindex="-1" role="dialog"
            aria-labelledby="formModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModal">Create Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            {{-- company --}}
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group" wire:model="new_company" >
                                    <label>Select Company</label>
                                    <select class="form-control" >
                                        <option value="0">-- Select Company-- </option>
                                        @foreach ($companies as $company)
                                            @if ($new_company == $company->id)
                                                <option value="{{ $company->id }}" selected>
                                                    {{ $company->company_name }}
                                                </option>
                                            @else
                                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                    @error('new_company')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- dealers --}}
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group"  wire:model="new_dealer">
                                    <label>Select Dealer</label>
                                    <select class="form-control">
                                        <option value="0">-- Select Dealer-- </option>
                                        @foreach ($dealers as $dealer)
                                            @if ($new_dealer == $dealer->id)
                                                <option value="{{ $dealer->id }}" selected>
                                                    {{ $dealer->name ."-".$dealer->tp }}
                                                </option>
                                            @else
                                                <option value="{{ $dealer->id }}">  {{ $dealer->name ."-".$dealer->tp }}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                    @error('new_dealer')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- name --}}
                            <div class="col-12 col-md-4 col-lg-4 ">
                                <div class="form-group">
                                    <label>Invoice Number</label>
                                  <input type="text" class="form-control" wire:model="new_invoice_number">
                                    @error('new_invoice_number')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- contact --}}
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Amount </label>
                                    <input type="number" class="form-control" wire:model="new_amount">
                                    @error('new_amount')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Date --}}
                            <div class="col-12 col-md-4 col-lg-4 ">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" class="form-control"  wire:model="new_date">
                                </div>
                                @error('new_date')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                            </div>

                             {{-- Date --}}
                             <div class="col-12 col-md-12 col-lg-12 ">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea type="text" class="form-control"  wire:model="new_description">

                                    </textarea>
                                </div>
                            </div>
                        </div>

                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="text-right">
                            <button type="button" wire:click="closeModel"
                                class="btn btn-danger m-t-15 waves-effect">Close </button>
                            <button type="button" wire:click="saveData"
                                class="btn btn-success m-t-15 waves-effect">Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- model end --}}



        {{-- delete model here --}}
        <div wire:ignore.self class="modal fade" id="delete-model" tabindex="-1" role="dialog"
            aria-labelledby="formModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="formModal">Warning!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">
                            If you want to remove this data, <b>you can't undo</b>, It will be affected that relevent
                            records!
                        </p>

                        <div class="text-right">
                            <button type="button" wire:click="deleteCloseModel"
                                class="btn btn-success m-t-15 waves-effect">No </button>
                            <button type="button" wire:click="deleteRecord"
                                class="btn btn-danger m-t-15 waves-effect">Yes</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- model end --}}
    </div>
</div>
