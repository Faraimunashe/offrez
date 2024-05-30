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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoom">
                            Add New
                        </button>
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
                                            <img src="{{asset('images/rooms')}}/{{$rp->picture ?? 'no-image.jfif'}}" alt="{{$room->name}}" width="40" height="30">
                                        </td>

                                        <td>
                                            <a href="{{route('rooms.show',$room->id)}}" class="btn btn-light"><i class="bi bi-eye"></i></a>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#edithouse{{ $room->id }}"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletehouse{{ $room->id }}"><i class="bi bi-trash"></i></button>
                                        </td>
                                            <!-- Edit tolfee Modal -->
                                            <div class="modal fade" id="edithouse{{ $room->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Room</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Name:</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="name" value="{{$room->name}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Capacity:</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="number" name="address" value="{{$room->capacity}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Description:</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="description" value="{{$room->description}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Price:</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="price" value="{{$room->price}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Pictures:</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="file" name="picture" class="form-control" accept="png,jpg,jpeg">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                         <!-- Delete tolfee Modal -->
                                         <div class="modal fade" id="deletehouse{{ $room->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Room</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 class="modal-title">Are you sure you want to pemanently delete this room?</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                            <button type="submit" class="btn btn-danger">Yes Delete</button>
                                                        </div>
                                                    </form>
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
    <div class="modal fade" id="addRoom" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Room</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="house_id" value="{{$house->id}}" required>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Name:</label>
                            <div class="col-sm-12">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Capacity:</label>
                            <div class="col-sm-12">
                                <input type="number" name="capacity" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Description:</label>
                            <div class="col-sm-12">
                                <input type="text" name="description" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Price:</label>
                            <div class="col-sm-12">
                                <input type="text" name="price" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Pictures:</label>
                            <div class="col-sm-12">
                                <input type="file" name="picture" class="form-control" accept="png,jpg,jpeg">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save new</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
