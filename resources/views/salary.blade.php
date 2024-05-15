@extends('header')

@section('title', 'Salary')


@section('content')
    <div class="content">

        <!-- Agents List -->
        <div class="card card-default">
            <div class="card-header">
                <h2>Salary</h2>

                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Add Salary
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
                            <th class="text-center" scope="col">Employs</th>
                            <th class="text-center" scope="col">Salary</th>
                            <th class="text-center" scope="col">Remark</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($salaries->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-danger">No Salaries Entries Added Yet</td>
                            </tr>
                        @else
                            @foreach ($salaries as $salary)
                                <tr>
                                    <td class="text-center">{{ $salary->date }}</td>
                                    <td class="text-center">{{ $salary->employ->name }}</td>
                                    <td class="text-center">₹{{ $salary->salary }}</td>
                                    <td class="text-center">{{ $salary->remark }}</td>
                                    <td style=" display:flex; justify-content:center;align-items-center">
                                        <a href="#" class="text-info mr-3 edit_agent"
                                            data-salary-id="{{ $salary->id }}" data-toggle="modal"
                                            data-target="#exampleModal"><span class="mdi mdi-pencil text-center"></span></a>
                                        <form method="POST" action="{{ route('salaries.destroy', $salary->id) }}"
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
            {{ $salaries->links() }}
        </div>
    </div>

    {{-- Modal Body Start --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Salary</h5>
                </div>
                <div class="modal-body">
                    <form id="agentForm" method="post" action="">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="salaryId" name="salaryId">

                            <div class="form-group col-md-6">
                                <label>Date</label>
                                <input type="date" id="date" name="date" value="{{ old('date') }}"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Employs</label>
                                <select class="form-control" name="employ_id" id="employ_id">
                                    <option value="">Select...</option>
                                    @foreach ($employs as $employ)
                                        <option value="{{ $employ->id }}">{{ $employ->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Salary</label>
                                <input type="text" id="salary" name="salary" value="{{ old('salary') }}"
                                    class="form-control" placeholder="Amount">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Remark</label>
                                <textarea type="text" id="remark" name="remark" value="{{ old('remark') }}" class="form-control"
                                    placeholder="Remark"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="saveButton">Add salary</button>
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
                var salaryId = $(this).data('salary-id');
                // AJAX request to fetch agent data

                $.ajax({
                    url: '/salaries/' + salaryId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        //console.log(response.email);

                        $('#exampleModalLabel').text('Edit salary');
                        $('#saveButton').text('Update salary');
                        // Update the form action to include the agent ID
                        $('#agentForm').attr('action', '/salaries/' + salaryId);
                        $('#salaryId').val(salaryId);
                        $('#date').val(response.date);
                        $('#employ_id').val(response.employ_id);
                        $('#salary').val(response.salary);
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
                if ($('#salaryId').val() != '') {
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
                            text: 'salary ' + (method == 'POST' ? 'added' :
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
