@push('sale', 'active')

<div>
    <div class="row">
        <div class="col-12 col-md-4">
        </div>
        <div class="col-12 col-md-8">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" id="search_bar" class="form-control" autofocus wire:click="searchClear"
                        wire:model="searchKey" wire:keyup="fetchData" placeholder="" aria-label="">
                    <div class="input-group-append">
                        <button class="btn btn-primary" wire:click="fetchData">Search</button>
                    </div>
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
                    <h5 class="modal-title" id="formModal">Customer Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- Customer info --}}
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Search Customer</label>
                                <input type="text" class="form-control" wire:model="customer_search"
                                    wire:keyup="fetchData">
                                @error('customer_search')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group" wire:model="new_customer_id">
                                <label>Select Customer</label>
                                <select class="form-control" wire:change="selectedCustomer">
                                    <option value="0">-- Select Customer-- </option>
                                    @foreach ($customers as $customer)
                                        @if ($new_customer_id == $customer->id)
                                            <option value="{{ $customer->id }}" selected>
                                                {{ $customer->customer_name . '-' . $customer->tp }}
                                            </option>
                                        @else
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->customer_name . '-' . $customer->tp }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('new_customer_id')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @if ($customer_data)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td style="background-color: rgba(228, 208, 33, 0.877)">Name</td>
                                    <td style="background-color: rgba(228, 208, 33, 0.877)">
                                        <b>{{ $customer_data->customer_name }}<b>
                                    </td>
                                    <td style="background-color: rgba(33, 202, 228, 0.877)">Tp</td>
                                    <td style="background-color: rgba(33, 202, 228, 0.877)"><b>
                                            {{ $customer_data->tp }}<b></td>
                                </tr>

                                <tr>
                                    <td style="background-color: rgb(225, 67, 67)">Credit</td>
                                    <td style="background-color: rgb(225, 67, 67)">{{ $customer_data->cridit }}</td>
                                    <td style="background-color: rgb(24, 236, 88)">Loyality</td>
                                    <td style="background-color: rgb(24, 236, 88)">{{ $customer_data->loyality }}</td>
                                </tr>
                            </table>
                        </div>
                    @endif
                    <div id="accordion">
                        <div class="accordion">
                            <div class="accordion-header" role="button" data-toggle="collapse"
                                data-target="#panel-body-1" aria-expanded="true" wire:click="activeView">
                                <h4>Create New Customer Not in List</h4>
                            </div>
                            <div class="accordion-body collapse {{ $active_panal == true ? 'show' : '' }}"
                                id="panel-body-1" data-parent="#accordion">
                                <p class="mb-0">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <div class="form-group">
                                            <label>Customer Name</label>
                                            <input type="text" class="form-control" wire:model="new_name">
                                            @error('new_name')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="text" class="form-control" wire:model="new_contact">
                                            @error('new_contact')
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

                                    <button type="button" wire:click="saveData"
                                        class="btn btn-success m-t-15 waves-effect">Create New Customer</button>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="text-right">
                        <button type="button" wire:click="closeModel" class="btn btn-danger m-t-15 waves-effect">Close
                        </button>
                        <button type="button" wire:click="closeModel"
                            class="btn btn-success m-t-15 waves-effect">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- model end --}}

    <div class="row">
        <div class="col-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="p-1">
                    <h3 align="center" class="text-info">Searched Item Result</h3>

                </div>
                <div class="card-body">
                    @if (sizeOf($list_data) != 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">

                                <tr>
                                    <td><b>Item Details</b> </td>
                                    <td><b>{{ $list_data[0]->category_name }}</b>-<b>{{ $list_data[0]->brand_name }}</b><br>
                                        {{ $list_data[0]->item_name . '-' . $list_data[0]->measure . $list_data[0]->measurement_name }}
                                        <br>
                                        <b>MFD:</b> {{ $list_data[0]->mfd }}
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Sel Price</b></td>
                                    <td>{{ number_format($list_data[0]->sell, 2) }}</td>
                                </tr>

                                <tr>
                                    <td><b>Expiry</b></td>
                                    <td>
                                        {{ $list_data[0]->expiry }}

                                        <br>
                                        @if (now() < $list_data[0]->expiry)
                                            <span class="text-success text-lg"><b>Item expire within
                                                    {{ \Carbon\Carbon::parse($list_data[0]->expiry)->diffForHumans() }}</b></span>
                                        @else
                                            <span class="text-danger"><b>Item expired
                                                    {{ \Carbon\Carbon::parse($list_data[0]->expiry)->diffForHumans() }}</b></span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td style="background-color: rgb(3, 123, 244);"><b>QTY-MAIN:
                                            {{ $list_data[0]->quantity }}</b></td>
                                    <td style="background-color: rgb(0, 255, 183);">
                                        @if (sizeOf($branch_data) != 0)
                                            <b>QTY-BRANCH:
                                                @if ($branch_data[0]->quantity == 0)
                                                    Out Of Stock In Branch
                                                @else
                                                    {{ $branch_data[0]->quantity }}
                                                @endif
                                            </b>
                                        @else
                                            Item Not in Branch
                                        @endif
                                    </td>

                                </tr>
                                @if (sizeOf($branch_data) != 0)

                                    @if ($branch_data[0]->quantity != 0)
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <label><b>Quantity</b></label>
                                                    <input type="number" class="form-control"
                                                        wire:model="new_sel_quantity">
                                                    @error('new_sel_quantity')
                                                        <span class="text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group">
                                                    <label><b>Sel Price</b></label>
                                                    <input type="number" class="form-control"
                                                        wire:model="new_sel_price">
                                                    @error('new_sel_price')
                                                        <span class="text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            </table>
                        </div>

                        @if (session()->has('main_message'))
                            <div class="alert alert-success">
                                {{ session('main_message') }}
                            </div>
                        @endif
                        @if (sizeOf($branch_data) != 0)
                            <div class="text-right">

                                <button type="button" wire:click="addToTemBIll"
                                    class="btn btn-primary btn-lg m-t-15 waves-effect p-2">
                                    <h4>Add to Bill</h4>
                                </button>
                            </div>
                        @endif
                    @else
                        <h4 align="center" class="text-danger">Item not Founded!</h4>
                    @endif
                </div>
            </div>
        </div>


        <div class="col-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="p-1">
                    @if (sizeOf($bill_item) != 0)
                        <div class="text-right">
                            @if ($customer_data)
                                <h4 style="background-color: rgba(12, 69, 239, 0.836); color:white;" class="p-1">
                                    Name:- {{ $customer_data->customer_name }} Tp:- {{ $customer_data->tp }} Credit:-
                                    {{ $customer_data->cridit }} Loyality:- {{ $customer_data->loyality }}
                                </h4>
                            @endif
                            <button type="button" wire:click="openModel"
                                class="btn btn-warning btn-lg m-t-15 waves-effect p-2">
                                <h4>Customer</h4>

                            </button>

                            <button type="button" wire:click="addToTemBIll"
                                class="btn btn-info btn-lg m-t-15 waves-effect p-2">
                                <h4>Complete Order/Pay</h4>
                            </button>

                        </div>
                    @endif

                </div>
                <div class="card-body p-2">
                    @if (sizeOf($bill_item) != 0)

                        <h3 align="right" class="p-2" style="background-color: rgba(6, 248, 66, 0.716);">Sub
                            Total=
                            {{ 'Rs.' . number_format($item_total, 2) }}</h3>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Details</th>
                                    <th>QTY</th>
                                    <th>U.P</th>
                                    <th>Total</th>
                                    <th>Trash</th>
                                </tr>
                                @php($x = 1)
                                @foreach ($bill_item as $row)
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td><b>{{ $row->category_name }}</b>-<b>{{ $row->brand_name }}</b><br>
                                            {{ $row->item_name . '-' . $row->measure . $row->measurement_name }}
                                            <br>

                                        </td>
                                        <td>{{ $row->quantity }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{ $row->quantity * $row->amount }}</td>
                                        <td>
                                            @if (in_array('Delete', $page_action))
                                                <a href="#" class="text-danger m-2"
                                                    wire:click="deleteOpenModel({{ $row->id }})"><i
                                                        class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php($x++)
                                @endforeach
                            </table>
                        </div>
        
                    @else
                        <h4 align="center" class="text-danger">Item not in Store</h4>

                    @endif
                </div>

            </div>
        </div>

        {{-- print recepit --}}
        <div id="printDocument" class="d-none">
            <h1 align="center">Testing</h1>
            <table style=" border:solid rgba(0, 0, 0, 0.658); border-width:1px 0px 0px 1px; width:99%" >
                <tr style="border:solid rgba(0, 0, 0, 0.658);
                border-width:10px 1px 1px 0;">
                    <th>#</th>
                    <th>Details</th>
                    <th>QTY</th>
                    <th>U.P</th>
                    <th>Total</th>

                </tr>
                @php($x = 1)
                @foreach ($bill_item as $row)
                    <tr>
                        <td>{{ $x }}</td>
                        <td><b>{{ $row->category_name }}</b>-<b>{{ $row->brand_name }}</b><br>
                            {{ $row->item_name . '-' . $row->measure . $row->measurement_name }}
                            <br>

                        </td>
                        <td>{{ $row->quantity }}</td>
                        <td>{{ $row->amount }}</td>
                        <td>{{ $row->quantity * $row->amount }}</td>

                    </tr>
                    @php($x++)
                @endforeach
            </table>
        </div>


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
                            If you want to remove this Item, It will be back to branch store!
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

    @push('scripts')
        <script>
            window.livewire.on('change-focus-other-field', function() {
                $("#search_bar").focus();
            });
        </script>
    @endpush
</div>
<script>
    window.addEventListener('do-print', event => {
        printrow();
    });

    function printrow() {
        var prtrow = document.getElementById("printDocument");
        var WinPrint = window.open();
        WinPrint.document.write(prtrow.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    }
</script>
