<x-app-layout>
    <div class="pagetitle">
        <h1>{{$house->name}}</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">House</li>
              </ol>
          </nav>
      </div>
      <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <x-alert/>
            <div class="col-md-6 mb-3">
                <div class="card card-body">
                    <div class="carousel-item active mt-3">
                        <img src="{{asset('images/houses')}}/{{$hp->picture ?? 'no-image.jfif'}}" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Name</th><td>{{$house->name}}</td>
                        </tr>
                        <tr>
                            <th>Address</th><td>{{$house->address}}</td>
                        </tr>
                        <tr>
                            <th>Description</th><td>{{$house->description}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Rooms</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Capacity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Picture</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($rooms as $room)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $rp = \App\Models\RoomPicture::where('room_id', $room->id)->orderBy('created_at', 'DESC')->first();
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $room->name }}</td>
                                        <td>{{ $room->capacity }}</td>
                                        <td>${{ $room->price }}</td>
                                        <td>{{ $room->status }}</td>
                                        <td>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#viewImage{{ $room->id }}">
                                                <img src="{{asset('images/rooms')}}/{{$rp->picture ?? 'no-image.jfif'}}" alt="{{$room->name}}" width="40" height="30">
                                            </a>
                                        </td>

                                        <td>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#book{{ $room->id }}">
                                                Book
                                            </button>
                                        </td>
                                            <!-- Edit tolfee Modal -->
                                            <div class="modal fade" id="book{{ $room->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Room Booking</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="room_id" value="{{$room->id}}" required>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Price:</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="amount" value="{{$room->price}}" class="form-control" required readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Phone: <code>ecocash/onemoney</code></label>
                                                                    <div class="col-sm-12">
                                                                        <input type="tel" name="phone" placeholder="0783540959" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Start Date</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="date" name="start_date" class="form-control" min="2024-05-30" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">End Date</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="date" name="end_date" class="form-control" min="2024-05-31" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Make payment</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                         <!-- Delete tolfee Modal -->
                                         <div class="modal fade" id="viewImage{{ $room->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Room Image</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{asset('images/rooms')}}/{{$rp->picture ?? 'no-image.jfif'}}" alt="{{$room->name}}" height="200">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
