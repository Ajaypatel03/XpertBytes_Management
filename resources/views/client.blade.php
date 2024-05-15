@extends('header')

@section('title', 'Clients')


@section('content')
    <div class="content">

        <!-- Agents List -->
        <div class="card card-default">
            <div class="card-header">
                <h2>Clients</h2>

                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Add Clients
                </button>

            </div>

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('alert-success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> {{ Session::get('alert-success') }}
                    </div>
                @endif

                <table class="table" id="agents">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Contact No.</th>
                            <th class="text-center" scope="col">Email</th>
                            <th class="text-center" scope="col">Address</th>
                            <th class="text-center" scope="col">Description</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($clients->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-danger">No Clients Added Yet</td>
                            </tr>
                        @else
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="text-center">{{ $client->name }}</td>
                                    <td class="text-center">{{ $client->mobile_no }}</td>
                                    <td class="text-center">{{ $client->email }}</td>
                                    <td class="text-center">{{ $client->address }}</td>
                                    <td class="text-center">{{ $client->description }}</td>
                                    <td style=" display:flex; justify-content:center;align-items-center">
                                        <a href="#" class="text-info mr-3 edit_agent"
                                            data-client-id="{{ $client->id }}" data-toggle="modal"
                                            data-target="#exampleModal"><span class="mdi mdi-pencil text-center"></span></a>
                                        <form method="POST" action="{{ route('clients.destroy', $client->id) }}"
                                            class="inner">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><a class="text-danger mr-3 text-center"><span
                                                        class="mdi mdi-trash-can"></span></a>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
        <div class="text-right">
            {{ $clients->links() }}
        </div>
    </div>

    {{-- Modal Body Start --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Client</h5>
                </div>
                <div class="modal-body">
                    <form id="agentForm" method="post" action="">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="clientId" name="clientId">

                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="Name">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Contact No.</label>
                                <input type="number" id="mobile_no" name="mobile_no" value="{{ old('mobile_no') }}"
                                    class="form-control" placeholder="90981xxxxx">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class=" email form-control" placeholder="ajay@gmail.com">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Address</label>
                                <input type="text" id="address" name="address" value="{{ old('address') }}"
                                    class="form-control" placeholder="Address">
                            </div>

                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea type="text" id="description" name="description" value="{{ old('description') }}" class="form-control"
                                    placeholder="Description"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="saveButton">Add Client</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Body Start --}}
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.edit_agent').click(function() {
                var clientId = $(this).data('client-id');
                // AJAX request to fetch agent data

                $.ajax({
                    url: '/clients/' + clientId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        //console.log(response.email);

                        $('#exampleModalLabel').text('Edit Client');
                        $('#saveButton').text('Update Client');
                        // Update the form action to include the agent ID
                        $('#agentForm').attr('action', '/clients/' + clientId);
                        $('#clientId').val(clientId);
                        $('#name').val(response.name);
                        $('#mobile_no').val(response.mobile_no);
                        $('.email').val(response.email);
                        $('#address').val(response.address);
                        $('#description').val(response.description);

                        $('#exampleModal').modal('show');
                    }
                });
            });

            $('#agentForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $(this).attr('action');
                var method = 'POST';
                if ($('#clientId').val() != '') {
                    method = 'PUT';
                }
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        $('#exampleModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Client ' + (method == 'POST' ? 'added' : 'updated') +
                                ' successfully',
                        }).then((result) => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            for (var key in errors) {
                                errorMessage += errors[key][0] + '\n';
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: errorMessage,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again.',
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
