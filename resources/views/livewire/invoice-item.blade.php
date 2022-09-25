@push('invoice', 'active')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-primary text-white-all">
            <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#"><i class="far fa-file"></i>Purchase</a></li>
            <li class="breadcrumb-item"><a href="/purchase-invoice"><i class="far fa-file"></i>Purchase Invoice</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>Invoice Item(s)</li>
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
                    @foreach ($purchase_invoice as $item)
                        <h4>Company -{{ $item->company_name }} - Invoice Number {{ $item->invoice_number }} <small> On
                                {{ $item->invoice_date }} <span class="text-secondary">
                                    {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span></small> </h4>
                    @endforeach

                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tableExport">
                            <tr>
                                <th>#</th>
                                <th>Barcode</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Buy</th>
                                <th>Sell</th>
                                <th>Min Sell</th>
                                <th>Expiry</th>
                                <th>MFD</th>
                                <th>Action</th>
                            </tr>
                            @php($x = 1)
                            @foreach ($list_data as $row)
                                <tr>
                                    <td>{{ $x }}</td>
                                    <td>
                                        <img src="{{ asset('barcodes/' . $row->barcode . '.png') }}">
                                        <h6 class="pl-4"> {{ $row->barcode }}</h6>
                                    </td>
                                    <td>
                                        <b> {{ $row->item_name }} -{{ $row->measure . '' . $row->measurement_name }}</b>
                                        <br>
                                        {{ $row->category_name }} - {{ $row->brand_name }}
                                    </td>
                                    <td>{{ $row->quantity }}</td>
                                    <td>{{ $row->buy }}</td>
                                    <td>{{ $row->sell }}</td>
                                    <td>{{ $row->min_sell }}</td>
                                    <td>

                                        {{ $row->expiry }}
                                        <br>
                                        @if (now() < $row->expiry)
                                            <small class="text-success text-lg"><b>Item expire within
                                                    {{ \Carbon\Carbon::parse($row->expiry)->diffForHumans() }}</b></small>
                                        @else
                                            <small class="text-danger"><b>Item expired
                                                    {{ \Carbon\Carbon::parse($row->expiry)->diffForHumans() }}</b></small>
                                        @endif
                                    </td>
                                    <td> {{ $row->mfd }}</td>

                                    <td>
                                        @if (in_array('Delete', $page_action))
                                            <a href="#" class="text-danger m-2"
                                                wire:click="deleteOpenModel({{ $row->id }})"><i
                                                    class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        @endif

                                        @if (in_array('Update', $page_action))
                                            <a href="#" class="text-info"
                                                wire:click="updateRecord({{ $row->id }})"><i class="fa fa-pen"
                                                    aria-hidden="true"></i>
                                            </a>
                                        @endif
                                        @if (in_array('Print', $page_action))
                                            <a href="/print-barcode/{{ $row->id }}" class="text-success">
                                                <i class="fa fa-print" aria-hidden="true"></i>
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

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group" wire:model="select_category">
                                    <select class="form-control">
                                        <option value="0">-- Category-- </option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group" wire:model="select_brand">
                                    <select class="form-control">
                                        <option value="0">-- Brand -- </option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>



                            {{-- Item --}}
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group" wire:model="new_item">
                                    <label>Select Item</label>
                                    <select class="form-control">
                                        <option value="0">-- Select Item-- </option>
                                        @foreach ($items as $item)
                                            @if ($new_item == $item->id)
                                                <option value="{{ $item->id }}" selected>{{ $item->item_name }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('new_item')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- quantity --}}
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" wire:model="new_quantity">
                                    @error('new_quantity')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- buy price --}}
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Buy price</label>
                                    <input type="number" class="form-control" wire:model="new_buy">

                                    @error('new_buy')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- sell price --}}
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Sell Price</label>
                                    <input type="number" class="form-control" required="" wire:model="new_sell">
                                    @error('new_sell')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>

                            {{-- min sell price --}}
                            <div class="col-12 col-md-4 col-lg-4 ">
                                <div class="form-group">
                                    <label>Min Sell price</label>
                                    <input type="number" class="form-control" required=""
                                        wire:model="new_min_sell">

                                    @error('new_min_sell')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Expiry date --}}
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Manufacturing Date</label>
                                    <input type="date" class="form-control" required=""
                                        wire:model="new_mfd_date">

                                    @error('new_mfd_date')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>


                            {{-- Expiry date --}}
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="date" class="form-control" required=""
                                        wire:model="new_expiry">

                                    @error('new_expiry')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
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
