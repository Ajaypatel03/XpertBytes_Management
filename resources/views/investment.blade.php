@extends('header')

@section('title', 'Investment')


@section('content')
    <div class="content">

        <!-- Agents List -->
        <div class="card card-default">
            <div class="card-header">
                <h2>Investment</h2>

                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Add Investment
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
                            <th class="text-center" scope="col">Date</th>
                            <th class="text-center" scope="col">Board Member</th>
                            <th class="text-center" scope="col">Amount</th>
                            <th class="text-center" scope="col">Remark</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($investment->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-danger">No Investment Entries Added Yet</td>
                            </tr>
                        @else
                            @foreach ($investment as $invest)
                                <tr>
                                    <td class="text-center">{{ $invest->date }}</td>
                                    {{--  <td class="text-center">{{ $invest->boardMember->name }}</td>  --}}
                                    <td class="text-center">{{ $invest->boardMember->name ?? 'N/A' }}</td>
                                    <td class="text-center">₹{{ $invest->amount }}</td>
                                    <td class="text-center">{{ $invest->remark }}</td>
                                    <td style=" display:flex; justify-content:center;align-items-center">
                                        <a href="#" class="text-info mr-3 edit_agent"
                                            data-invest-id="{{ $invest->id }}" data-toggle="modal"
                                            data-target="#exampleModal"><span class="mdi mdi-pencil text-center"></span></a>
                                        <form method="POST" action="{{ route('invest.destroy', $invest->id) }}"
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
            {{ $investment->links() }}
        </div>
    </div>

    {{-- Modal Body Start --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Investment</h5>
                </div>
                <div class="modal-body">
                    <form id="agentForm" method="post" action="">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="investId" name="investId">

                            <div class="form-group col-md-6">
                                <label>Date</label>
                                <input type="date" id="date" name="date" value="{{ old('date') }}"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Board Members</label>
                                <select class="form-control" name="board_members_id" id="board_members_id">
                                    <option value="">Select...</option>
                                    @foreach ($boardMembers as $boardMember)
                                        <option value="{{ $boardMember->id }}">{{ $boardMember->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Amount</label>
                                <input type="text" id="amount" name="amount" value="{{ old('amount') }}"
                                    class="form-control" placeholder="Amount">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Remark</label>
                                <textarea type="text" id="remark" name="remark" value="{{ old('remark') }}" class="form-control"
                                    placeholder="Remark"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="saveButton">Add Investment</button>
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
                var investId = $(this).data('invest-id');
                // AJAX request to fetch agent data

                $.ajax({
                    url: '/invest/' + investId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        //console.log(response.email);

                        $('#exampleModalLabel').text('Edit Invest Entry');
                        $('#saveButton').text('Update Invest Entry');
                        // Update the form action to include the agent ID
                        $('#agentForm').attr('action', '/invest/' + investId);
                        $('#investId').val(investId);
                        $('#date').val(response.date);
                        $('#board_members_id').val(response.board_members_id);
                        $('#amount').val(response.amount);
                        $('#remark').val(response.remark);

                        $('#exampleModal').modal('show');
                    }
                });
            });

            $('#agentForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $(this).attr('action');
                var method = 'POST';
                if ($('#investId').val() != '') {
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
                            text: 'Invest Entry ' + (method == 'POST' ? 'added' :
                                    'updated') +
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
