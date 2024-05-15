@extends('header')

@section('title', 'DashBoard')

@section('content')
    <div class="content-wrapper">
        <div class="content">
            <!-- Top Statistics -->
            <div class="row">


                <div class="col-xl-4 col-md-6">
                    <div class="card card-default bg-secondary">
                        <div class="d-flex p-5 justify-content-between">
                            <div class="icon-md bg-white rounded-circle mr-3">
                                <i class="mdi mdi-account-group text-secondary"></i>
                            </div>
                            <div class="text-right">
                                <span class="h2 d-block text-white">{{ $boardMemberscount }}</span>
                                <p class="text-white">Board Members</p>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('boardMembers.index') }}" class="text-white"> More info <span
                                    class="mdi mdi-arrow-right-bold-circle"></span></a>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-md-6">
                    <div class="card card-default bg-success">
                        <div class="d-flex p-5 justify-content-between">
                            <div class="icon-md bg-white rounded-circle mr-3">
                                <i class="mdi mdi-account-multiple-outline text-success"></i>
                            </div>
                            <div class="text-right">
                                <span class="h2 d-block text-white">{{ $employscount }}</span>
                                <p class="text-white">Employees</p>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('employs.index') }}" class="text-white"> More info <span
                                    class="mdi mdi-arrow-right-bold-circle"></span></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card card-default bg-primary">
                        <div class="d-flex p-5 justify-content-between">
                            <div class="icon-md bg-white rounded-circle mr-3">
                                <i class="mdi mdi-account-circle text-primary"></i>
                            </div>
                            <div class="text-right">
                                <span class="h2 d-block text-white">{{ $clientscount }}</span>
                                <p class="text-white">Clients</p>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('clients.index') }}" class="text-white"> More info <span
                                    class="mdi mdi-arrow-right-bold-circle"></span></a>
                        </div>
                    </div>
                </div>



            </div>
        </div>

    </div>
@endsection
