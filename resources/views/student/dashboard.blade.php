<x-app-layout>
    <div class="pagetitle">
        <h1>Student Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <x-alert/>
            @foreach ($houses as $house)
                @php
                    $hp = \App\Models\HousePicture::where('house_id', $house->id)->orderBy('created_at', 'DESC')->first();
                @endphp
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $house->name }}</h5>
                            <div class="carousel-item active">
                                <img src="{{asset('images/houses')}}/{{$hp->picture ?? 'no-image.jfif'}}" class="d-block w-100" alt="..." height="200">
                            </div>
                        </div>
                        <div class="card-footer">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Rooms</th> <td>{{ \App\Models\Room::where('house_id', $house->id)->count() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th> <td>{{ substr($house->address, 0, 20) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{route('student-house',$house->id)}}" class="btn btn-primary btn-group-sm w-100">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
