{{-- <div>
       <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row ">
                        <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15"> Total Customers</h5>
                                <h2 class="mb-3 font-16">{{ $list_data }}</h2>
                                <p class="mb-0">‎</p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="{{ asset('assets/img/banner/2.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
</div>  --}}


<div class="">
    <section class="section">
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 pr-0 pt-4">
                                        <div class="card-content">
                                            <h5 class="font-15">Total Customers</h5>
                                            <h2 class="mb-3 font-16">{{ $customers }}</h2>
                                            <p class="mb-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/customers.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>



            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15"> Total Purchases</h5>
                                        <h2 class="mb-3 font-16">{{ number_format($purchase_invoices, 2) }}</h2>
                                        <p class="mb-0">‎</p>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                    <div class="banner-img">
                                        <img src="{{ asset('assets/img/banner/purchases.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Total Branches</h5>
                                            <h2 class="mb-3 font-16">
                                                {{ $branch_stores }} </h2>
                                            <p class="mb-0">‎</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/branches.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Total Expenses</h5>
                                            <h2 class="mb-3 font-16">{{ number_format($expenses, 2) }}</h2>
                                            <p class="mb-0">‎</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/expenses.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Dealers</h5>
                                        <h2 class="mb-3 font-16">{{ $dealers }}</h2>
                                        <p class="mb-0">‎</p>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                    <div class="banner-img">
                                        <img src="{{ asset('assets/img/banner/dealers.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>


            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row ">
                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Shops</h5>
                                        <h2 class="mb-3 font-16">{{ $shops }}</h2>

                                        <p class="mb-0">‎</p>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 pl-0">
                                    <div class="banner-img">
                                        <img src="{{ asset('assets/img/banner/1.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>
</div>

</section>
</div>
