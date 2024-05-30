<x-app-layout>
    <div class="pagetitle">
        <h1>Landlord Transactions</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Transactions</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <x-alert/>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transactions</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Student</th>
                                    <th scope="col">House</th>
                                    <th scope="col">Room</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $transaction->student }}</td>
                                        <td>{{ $transaction->house }}</td>
                                        <td>{{ $transaction->room }}</td>
                                        <td>${{ $transaction->amount }}</td>
                                        <td>{{ $transaction->method }}</td>
                                        <td>{{ $transaction->status }}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$transactions->links('pagination::bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
