@extends('layout/Layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row" id="proBanner">

            </div>
            <div class="d-xl-flex justify-content-between align-items-start">
                <h2 class="text-dark font-weight-bold mb-2"> Overview dashboard </h2>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border {">


                    </div>
                    <div class="tab-content tab-transparent-content">
                        <div class="tab-pane fade show active" id="business-1" role="tabpanel">
                            <div class="row">

                              @if (Auth()->user()->type == "Master Admin")
                                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">


                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h5 class="mb-2 text-dark font-weight-normal">All Products</h5>
                                                <h2 class="mb-4 text-dark font-weight-bold">
                                                    {{ $Allprodect }}
                                                </h2>
                                                <div
                                                    class="dashboard-progress dashboard-progress-1 d-flex align-items-center justify-content-center item-parent">
                                                    <i class="mdi mdi-lightbulb icon-md absolute-center text-dark"></i>
                                                </div>
                                                <p class="mt-4 mb-0">Completed</p>
                                                <h3 class="mb-0 font-weight-bold mt-2 text-info">Active 
                                                    {{  $product_Active }}
                                                </h3>
                                                <h3 class="mb-0 font-weight-bold mt-2 text-danger">UnActive
                                                    {{ $product_Unactive }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h5 class="mb-2 text-dark font-weight-normal">All Suppliers</h5>
                                                <h2 class="mb-4 text-dark font-weight-bold">
                                                   {{$All_Suplliers}}
                                                </h2>
                                                <div
                                                    class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent">
                                                    <i class="mdi mdi-account-circle icon-md absolute-center text-dark"></i>
                                                </div>
                                                <p class="mt-4 mb-0">Increased since yesterday</p>
                                                <h3 class="mb-0 font-weight-bold mt-2 text-dark">50%</h3>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h5 class="mb-2 text-dark font-weight-normal">All Clinics</h5>
                                                <h2 class="mb-4 text-dark font-weight-bold">
                                                  {{$All_Clinic}}
                                                </h2>
                                                <div
                                                    class="dashboard-progress dashboard-progress-3 d-flex align-items-center justify-content-center item-parent">
                                                    <i class="mdi mdi-eye icon-md absolute-center text-dark"></i>
                                                </div>
                                                <p class="mt-4 mb-0">Increased since yesterday</p>
                                                <h3 class="mb-0 font-weight-bold mt-2 text-dark">35%</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h5 class="mb-2 text-dark font-weight-normal">Balance</h5>
                                            <h2 class="mb-4 text-dark font-weight-bold">$
                                              {{$blananc}}
                                            </h2>
                                            <div
                                                class="dashboard-progress dashboard-progress-4 d-flex align-items-center justify-content-center item-parent">
                                                <i class="mdi mdi-cube icon-md absolute-center text-dark"></i>
                                            </div>
                                            <p class="mt-4 mb-0">Decreased since yesterday</p>
                                            <h3 class="mb-0 font-weight-bold mt-2 text-dark">25%</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
