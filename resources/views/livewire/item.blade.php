@push('item', 'active')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-primary text-white-all">
            <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#"><i class="far fa-file"></i> Create New</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>Item(s)</li>
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
                    <h4>Item(s)</h4>

                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tableExport">
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Measure</th>
                                <th>Items</th>
                                <th>Action</th>
                            </tr>
                            @php($x = 1)
                            @foreach ($list_data as $row)
                                <tr>
                                    <td>{{ $x }}</td>
                                    <td>{{ $row->category_name }}</td>
                                    <td>{{ $row->brand_name }}</td>
                                    <td>{{ $row->measure . $row->measurement_name }}</td>
                                    <td>{{ $row->item_name }}</td>

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
                        <h5 class="modal-title" id="formModal">
                            {{ ($key==0)?"Create Data":"Update Data";}}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group" wire:model="new_category">
                                    <label>Select Category</label>
                                    <select class="form-control">
                                        <option value="0">-- Select Category-- </option>
                                        @foreach ($categories as $category)
                                            @if ($new_category == $category->id)
                                                <option value="{{ $category->id }}" selected>{{ $category->category }}
                                                </option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('new_category')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- brand --}}
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group" wire:model="new_brand">
                                    <label>Select Brand</label>
                                    <select class="form-control">
                                        <option value="0">-- Select Brand-- </option>
                                        @foreach ($brands as $brand)
                                            @if ($new_brand == $brand->id)
                                                <option value="{{ $brand->id }}" selected>{{ $brand->brand }}
                                                </option>
                                            @else
                                                <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('new_brand')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Measurement --}}
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group" wire:model="new_measurement">
                                    <label>Select Measurements </label>
                                    <select class="form-control">
                                        <option value="0">-- Select Measurement-- </option>
                                        @foreach ($measurements as $measurement)
                                            @if ($measurement->id == $new_measurement)
                                                <option value="{{ $measurement->id }}" selected>
                                                    {{ $measurement->measurement }}</option>
                                            @else
                                                <option value="{{ $measurement->id }}">{{ $measurement->measurement }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('new_measurement')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Unit --}}
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Measure Unit</label>
                                    <input type="number" class="form-control" required="" min="0"
                                        wire:model="new_measure">
                                    @error('new_measure')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- name --}}
                            <div class="col-12 col-md-12 col-lg-12 ">
                                <div class="form-group">
                                    <label>Item-Name</label>
                                    <input type="text" class="form-control" required="" wire:model="new_item">

                                    @error('new_item')
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
