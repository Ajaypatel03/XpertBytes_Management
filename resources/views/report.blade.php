@extends('header')

@section('title', 'Report')

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
                <h2>Report</h2>
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



                <form action="{{ route('report.index') }}" method="GET">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>From Date</label>
                            <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>To Date</label>
                            <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit"
                                class="btn btn-primary btn-sm mt-6"style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Filter</button>
                            <a href="{{ route('report.index') }}"
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
                            <th class="text-center">Management Type</th>
                            <th class="text-center">Credit</th>
                            <th class="text-center">Debit</th>
                            <th class="text-center">Balance</th>
                            <th class="text-center">Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $runningBalance = 0;
                        @endphp
                        @foreach ($entries as $entry)
                            @php
                                // Calculate the balance for the current entry
                                $balance =
                                    $entry->management_id == 0 || $entry->management_id == 4
                                        ? $runningBalance + $entry->amount
                                        : $runningBalance - $entry->amount;
                                // Update the running balance for the next iteration
                                $runningBalance = $balance;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $entry->date }}</td>
                                <td class="text-center">
                                    {{ $entry->management_id == 0
                                        ? 'Client'
                                        : ($entry->management_id == 1
                                            ? 'Salary'
                                            : ($entry->management_id == 2
                                                ? 'Expense'
                                                : ($entry->management_id == 3
                                                    ? 'Debit'
                                                    : ($entry->management_id == 4
                                                        ? 'Investment'
                                                        : '')))) }}
                                </td>

                                <td class="text-center text-success">
                                    {{ $entry->management_id == 0 || $entry->management_id == 4 ? '₹' . $entry->amount : '-' }}
                                </td>
                                <td class="text-center text-danger">
                                    {{ $entry->management_id == 1 || $entry->management_id == 2 || $entry->management_id == 3 ? '₹' . $entry->amount : '-' }}
                                </td>
                                <td class="text-center">₹{{ $balance }}</td>
                                <td class="text-center">{{ $entry->remark }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center"><strong>Total</strong></td>
                            <td></td>
                            <td class="text-center"><strong>{{ $credit != 0 ? '₹' . $credit : '-' }}</strong></td>
                            <td class="text-center"><strong>{{ $debit != 0 ? '₹' . $debit : '-' }}</strong></td>
                            <td class="text-center"><strong>{{ $total != 0 ? '₹' . $total : '-' }}</strong></td>
                        </tr>
                    </tbody>
                </table>



            </div>

        </div>
        {{--  <div class="text-right mb-2">
            {{ $entries->links() }}
        </div>  --}}

    </div>

@endsection

@section('script')

@endsection
