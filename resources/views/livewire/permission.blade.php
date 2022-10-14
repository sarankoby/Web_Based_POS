<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-primary text-white-all">
            <li class="breadcrumb-item"><a href="/home"><i class="fas fa-tachometer-alt"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#"><i class="far fa-file"></i>Auth</a></li>
            <li class="breadcrumb-item"><a href="/user-type"><i class="fas fa-list"></i>User-Type</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i>Permissions</li>
        </ol>
    </nav>

    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div style="padding: 10px;">


                            <h4 align="center" class="pt-2">

                                <b> ( {{ $user_type->user_type }} ) </b>- Permission
                            </h4>


                        </div>
                        <div class="card-body">


                            <div class="card-body">
                                @foreach ($access_model as $rowx)
                                    <h5 class="card-title"><u>{{ $rowx->access_model }}</u></h5>
                                    <div class="row">
                                        @foreach ($access_point as $row)
                                            @if ($rowx->id == $row->access_model_id)
                                                <div class="col-2">
                                                    <div class="position-relative form-group">
                                                        <div class="custom-checkbox custom-control">

                                                            @if (count($permissionData) != 0)
                                                                <?php
                                                                $val = json_decode($permissionData[0]->permission);
                                                                
                                                                ?>

                                                                @if (in_array($row->id, $val))
                                                                    <input type="checkbox" id={{ $row->id }}
                                                                        value={{ $row->id }} checked
                                                                        wire:click="givePermission({{ $row->id }})"
                                                                        class="custom-control-input">
                                                                    <label class="custom-control-label"
                                                                        for={{ $row->id }}>
                                                                        {{ $row->value }}
                                                                    </label>
                                                                @else
                                                                    <input type="checkbox"
                                                                        wire:click="givePermission({{ $row->id }})"
                                                                        id={{ $row->id }} value={{ $row->id }}
                                                                        class="custom-control-input">
                                                                    <label class="custom-control-label"
                                                                        for={{ $row->id }}>
                                                                        {{ $row->value }}
                                                                    </label>
                                                                @endif
                                                            @else
                                                                <input type="checkbox"
                                                                    wire:click="givePermission({{ $row->id }})"
                                                                    id={{ $row->id }} value={{ $row->id }}
                                                                    class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                    for={{ $row->id }}>
                                                                    {{ $row->value }}
                                                                </label>
                                                            @endif

                                                        </div>

                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
