@push('stock-transfer', 'active')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-primary text-white-all">
            <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#"><i class="far fa-file"></i> Stock</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>Stock Transfer</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12 col-md-4">
        </div>
        <div class="col-12 col-md-8">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" id="search_bar" class="form-control" autofocus wire:click="searchClear"  wire:model="searchKey"
                        wire:keyup="fetchData" placeholder="" aria-label="">
                    <div class="input-group-append">
                        <button class="btn btn-primary" wire:click="fetchData">Search</button>
                    </div>

                    {{-- @if (in_array('Save', $page_action))
                        <button id="formOpen" wire:click="openModel" class="btn btn-info ml-1"><i class="fa fa-plus"
                                aria-hidden="true"></i> Create-New
                        </button>
                    @endif --}}

                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 align="center">Item Details</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Item Name</th>
                                <th>Sel Price</th>
                                <th>MFD</th>
                                <th>Expiry</th>
                            </tr>
                            @if (sizeOf($list_data) != 0)
                                <tr>
                                    <td>{{ $list_data[0]->category_name }}</td>
                                    <td>{{ $list_data[0]->brand_name }}</td>
                                    <td>{{ $list_data[0]->item_name . '-' . $list_data[0]->measure . $list_data[0]->measurement_name }}
                                    </td>
                                    <td>{{ number_format($list_data[0]->sell, 2) }}</td>
                                    <td>{{ $list_data[0]->mfd }}</td>
                                    <td>
                                        {{ $list_data[0]->expiry }}

                                        <br>
                                        @if (now() < $list_data[0]->expiry)
                                            <small class="text-success text-lg"><b>Item expire within
                                                    {{ \Carbon\Carbon::parse($list_data[0]->expiry)->diffForHumans() }}</b></small>
                                        @else
                                            <small class="text-danger"><b>Item expired
                                                    {{ \Carbon\Carbon::parse($list_data[0]->expiry)->diffForHumans() }}</b></small>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="p-1">
                    <h4 align="center" class="text-info">Main Store</h4>

                </div>
                <div class="card-body p-2">
                    @if (sizeOf($list_data) != 0)
                        <h4 align="center"> Available Quantity : {{ $list_data[0]->quantity }}</h4>
                        <div class="form-group">
                            <label><b>Quantity</b></label>
                            <input type="number"  class="form-control" wire:model="new_main_quantity">
                            @error('new_main_quantity')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        @if (session()->has('main_message'))
                            <div class="alert alert-success">
                                {{ session('main_message') }}
                            </div>
                        @endif

                        <div class="text-right">
                            <button type="button" wire:click="closeModel"
                                class="btn btn-danger m-t-15 waves-effect">Clear </button>
                            <button type="button" wire:click="mainToBranchTransfer"
                                class="btn btn-primary m-t-15 waves-effect">Transfer To Branch</button>
                        </div>
                        @else
                        <h4 align="center" class="text-danger">Item not Founded!</h4>
                         @endif
                </div>
            </div>
        </div>


        <div class="col-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="p-1">
                    <h4 align="center" class="text-success">Branch Store</h4>

                </div>
                <div class="card-body p-2">
                    @if (sizeOf($branch_data) != 0)
                        <h4 align="center"> Available Quantity :{{ $branch_data[0]->quantity }}</h4>
                        <div class="form-group">
                            <label><b>Quantity</b></label>
                            <input type="number" class="form-control" wire:model="new_branch_quantity">
                            @error('new_name')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        @if (session()->has('branch_message'))
                            <div class="alert alert-success">
                                {{ session('branch_message') }}
                            </div>
                        @endif

                        <div class="text-right">
                            <button type="button" wire:click="closeModel"
                                class="btn btn-danger m-t-15 waves-effect">Clear </button>
                            <button type="button" wire:click="branchToMainTransfer"
                                class="btn btn-primary m-t-15 waves-effect">Back to Main</button>
                        </div>
                    @else
                        <h4 align="center" class="text-danger">Item not in Store</h4>

                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
<script>
   window.livewire.on('change-focus-other-field', function () {
        $("#search_bar").focus();
    });

</script>
@endpush
</div>

