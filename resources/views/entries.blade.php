@extends('header')

@section('title', 'Entries')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.js"></script>
<script>
    function printReport() {
        window.print();
    }
</script>

@section('content')
    <div class="content">
        {{--  <button onclick="generatePDF()" class="btn btn-primary btn-sm mt-6">PDF</button>  --}}

        <!-- Agents List -->
        <div class="card card-default">

            <div class="card-header">
                <h2>Entries</h2>

                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Add Entry
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



                <form action="{{ route('entries.index') }}" method="GET">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>From Date</label>
                            <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>To Date</label>
                            <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Type Of Entry</label>
                            <select class="form-control" name="management_id" id="management_id">
                                <option value="">Select...</option>
                                <option value="0"{{ request('management_id') == '0' ? 'selected' : '' }}>Clients
                                </option>
                                <option value="1"{{ request('management_id') == '1' ? 'selected' : '' }}>Salary
                                </option>
                                <option value="2"{{ request('management_id') == '2' ? 'selected' : '' }}>Expense
                                </option>
                                <option value="3"{{ request('management_id') == '3' ? 'selected' : '' }}>Debt</option>
                                <option value="4"{{ request('management_id') == '4' ? 'selected' : '' }}>Investment
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <button type="submit"
                                class="btn btn-primary btn-sm mt-6"style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Filter</button>
                            <a href="{{ route('entries.index') }}"
                                class="btn btn-secondary btn-sm mt-6"style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Reset</a>
                            <button onclick="printReport()" class="btn btn-warning btn-sm mt-6"
                                style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Print</button>
                        </div>
                    </div>
                </form>



                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Management</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Remark</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($entries->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-danger">No Entries Posted Yet</td>
                            </tr>
                        @else
                            @php
                                $totalAmount = 0;
                            @endphp
                            @foreach ($entries as $entry)
                                @php
                                    $totalAmount += $entry->amount;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $entry->date }}</td>
                                    <td class="text-center">
                                        @if ($entry->type_of_entry)
                                            @php
                                                $type = '';
                                                $managementName = '';
                                                switch ($entry->management_id) {
                                                    case 0:
                                                        $type = 'Client';
                                                        $managementName = $entry->client->name;
                                                        break;
                                                    case 1:
                                                        $type = 'Salary';
                                                        $managementName = $entry->employ->name;
                                                        break;
                                                    case 2:
                                                        $type = 'Expense';
                                                        break;
                                                    case 3:
                                                        $type = 'Debt';
                                                        $managementName = $entry->boardMember->name;
                                                        break;
                                                    case 4:
                                                        $type = 'Investment';
                                                        $managementName = $entry->boardMember->name;
                                                        break;
                                                    default:
                                                        $type = 'Unknown';
                                                        break;
                                                }
                                            @endphp
                                            {{ $managementName }} ({{ $type }})
                                        @endif
                                    </td>
                                    <td class="text-center">₹{{ $entry->amount }}</td>
                                    <td class="text-center">{{ $entry->remark }}</td>
                                    <td style="display:flex; justify-content:center;align-items:center">
                                        <a href="#" class="text-info mr-3 edit_agent"
                                            data-entry-id="{{ $entry->id }}" data-toggle="modal"
                                            data-target="#exampleModal">
                                            <span class="mdi mdi-pencil text-center"></span>
                                        </a>
                                        <form method="POST" action="{{ route('entries.destroy', $entry->id) }}"
                                            class="inner">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger mr-3 text-center">
                                                <span class="mdi mdi-trash-can"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-center">Total Balance:</td>
                                <td></td>
                                <td class="text-center">₹{{ $totalAmount }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>


            </div>

        </div>
        <div class="text-right mb-2">
            {{ $entries->links() }}
        </div>

    </div>

    {{-- Modal Body Start --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Entry</h5>
                </div>
                <div class="modal-body">
                    <form id="agentForm" method="post" action="">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="entryId" name="entryId">

                            <div class="form-group col-md-6">
                                <label>Date</label>
                                <input type="date" id="date" name="date" value="{{ old('date') }}"
                                    class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Type Of Entry</label>
                                <select class="form-control" name="type_of_entry" id="type_of_entry">
                                    <option value="">Select...</option>
                                    <option value="0">Clients</option>
                                    <option value="1">Salary</option>
                                    <option value="2">Expense</option>
                                    <option value="3">Debt</option>
                                    <option value="4">Investment</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="board_members_container" style="display: none;">
                                <label>Board Members</label>
                                <select class="form-control" name="board_member_id" id="board_member_id">
                                    <option value="">Select...</option>
                                    @foreach ($boardMembers as $boardMember)
                                        <option value="{{ $boardMember->id }}">{{ $boardMember->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-6" id="clients_container" style="display: none;">
                                <label>Clients</label>
                                <select class="form-control" name="client_id" id="client_id">
                                    <option value="">Select...</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="employs_container" style="display: none;">
                                <label>Employees</label>
                                <select class="form-control" name="employ_id" id="employ_id">
                                    <option value="">Select...</option>
                                    @foreach ($employees as $employ)
                                        <option value="{{ $employ->id }}">{{ $employ->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Amount</label>
                                <input type="text" id="amount" name="amount" value="{{ old('amount') }}"
                                    class="form-control" placeholder="1000rs">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Remark</label>
                                <textarea type="text" id="remark" name="remark" value="{{ old('remark') }}" class="form-control"
                                    placeholder="ajay...."></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm" id="saveButton">Add Entry</button>
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

            function showContainers(selectedValue) {
                var boardMembersContainer = $('#board_members_container');
                var clientsContainer = $('#clients_container');
                var employsContainer = $('#employs_container');

                boardMembersContainer.hide();
                clientsContainer.hide();
                employsContainer.hide();

                if (selectedValue === '3' || selectedValue === '4') {
                    boardMembersContainer.show();
                } else if (selectedValue === '0') {
                    clientsContainer.show();
                } else if (selectedValue === '1') {
                    employsContainer.show();
                }
            }


            $('#type_of_entry').on('change', function() {
                var selectedValue = $(this).val();
                showContainers(selectedValue);
            });

            $('.edit_agent').click(function() {
                var entryId = $(this).data('entry-id');

                $.ajax({
                    url: '/entries/' + entryId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#exampleModalLabel').text('Edit Entry');
                        $('#saveButton').text('Update Entry');
                        $('#agentForm').attr('action', '/entries/' + entryId);
                        $('#entryId').val(entryId);
                        $('#date').val(response.date);
                        $('#type_of_entry').val(response.management_id);
                        $('#amount').val(response.amount);
                        $('#remark').val(response.remark);

                        // Show/hide containers based on the selected type of entry
                        showContainers(response.type_of_entry);

                        if (response.management_id == 0) {
                            $('#clients_container').show();
                            $('#employs_container').hide();
                            $('#board_members_container').hide();
                            $('#client_id').val(response.type_of_entry);
                        } else if (response.management_id == 1) {
                            $('#employs_container').show();
                            $('#clients_container').hide();
                            $('#board_members_container').hide();
                            $('#employ_id').val(response.type_of_entry);
                        } else if (response.management_id == 2) {
                            $('#type_of_entry').val(response.management_id);
                        } else if (response.management_id == 3, 4) {
                            $('#board_members_container').show();
                            $('#clients_container').hide();
                            $('#employs_container').hide();
                            $('#board_member_id').val(response.type_of_entry);
                        }

                        $('#exampleModal').modal('show');
                    }
                });
            });

            $('#agentForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $(this).attr('action');
                var method = 'POST';
                if ($('#entryId').val() != '') {
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
                            text: 'Entry ' + (method == 'POST' ? 'added' : 'updated') +
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
