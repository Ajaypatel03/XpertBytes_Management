@extends('header')

@section('title', 'Board Memebers')


@section('content')
    <div class="content">

        <!-- Agents List -->
        <div class="card card-default">
            <div class="card-header">
                <h2>Board Members</h2>

                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Add Members
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
                            <th class="text-center" scope="col">Designation</th>
                            <th class="text-center" scope="col">Contact No.</th>
                            <th class="text-center" scope="col">Email</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($boardMembers->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-danger">No BoardMembers Added Yet</td>
                            </tr>
                        @else
                            @foreach ($boardMembers as $boardmember)
                                <tr>
                                    <td class="text-center">{{ $boardmember->name }}</td>
                                    <td class="text-center">{{ $boardmember->designation }}</td>
                                    <td class="text-center">{{ $boardmember->mobile_no }}</td>
                                    <td class="text-center">{{ $boardmember->email }}</td>
                                    <td style=" display:flex; justify-content:center;align-items-center">
                                        <a href="#" class="text-info mr-3 edit_agent"
                                            data-boardmember-id="{{ $boardmember->id }}" data-toggle="modal"
                                            data-target="#exampleModal"><span class="mdi mdi-pencil text-center"></span></a>
                                        <form method="POST" action="{{ route('boardMembers.destroy', $boardmember->id) }}"
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
            {{ $boardMembers->links() }}
        </div>
    </div>

    {{-- Modal Body Start --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
                </div>
                <div class="modal-body">
                    <form id="agentForm" method="post" action="">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="boardmemberId" name="boardmemberId">

                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="Name">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Designation</label>
                                <input type="text" id="designation" name="designation" value="{{ old('designation') }}"
                                    class="form-control" placeholder="Designation">
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

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="saveButton">Add Member</button>
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
                var boardmemberId = $(this).data('boardmember-id');
                // AJAX request to fetch agent data

                $.ajax({
                    url: '/boardMembers/' + boardmemberId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        //console.log(response.email);

                        $('#exampleModalLabel').text('Edit Member');
                        $('#saveButton').text('Update Member');
                        // Update the form action to include the agent ID
                        $('#agentForm').attr('action', '/boardMembers/' + boardmemberId);
                        $('#boardmemberId').val(boardmemberId);
                        $('#name').val(response.name);
                        $('#designation').val(response.designation);
                        $('#mobile_no').val(response.mobile_no);
                        $('.email').val(response.email);

                        $('#exampleModal').modal('show');
                    }
                });
            });

            $('#agentForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $(this).attr('action');
                var method = 'POST';
                if ($('#boardmemberId').val() != '') {
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
                            text: 'Member ' + (method == 'POST' ? 'added' : 'updated') +
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
