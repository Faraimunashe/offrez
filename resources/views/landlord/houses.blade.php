<x-app-layout>
    <div class="pagetitle">
        <h1>Houses</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Houses</li>
              </ol>
          </nav>
      </div>
      <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <x-alert/>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">House</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHouse">
                            Add New
                        </button>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Rooms</th>
                                    <th scope="col">Picture</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($houses as $house)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $hp = \App\Models\HousePicture::where('house_id', $house->id)->orderBy('created_at', 'DESC')->first();
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $house->name }}</td>
                                        <td>{{ $house->address }}</td>
                                        <td>{{ \App\Models\Room::where('house_id', $house->id)->count() }}</td>
                                        <td>
                                            <img src="{{asset('images/houses')}}/{{$hp->picture ?? 'no-image.jfif'}}" alt="{{$house->name}}" width="40" height="30">
                                        </td>

                                        <td>
                                            <a href="{{route('houses.show',$house->id)}}" class="btn btn-light"><i class="bi bi-eye"></i></a>
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addRoom{{ $house->id }}"><i class="bi bi-door-open"></i></button>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#edithouse{{ $house->id }}"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletehouse{{ $house->id }}"><i class="bi bi-trash"></i></button>
                                        </td>
                                            <!-- Edit tolfee Modal -->
                                            <div class="modal fade" id="edithouse{{ $house->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form action="{{ route('houses.update', $house->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update House</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Name:</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="name" value="{{$house->name}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Address:</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="address" value="{{$house->address}}" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputText" class="col-sm-12 col-form-label">Description:</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="description" value="{{$house->description}}" class="form-control" required>
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


                                            <div class="modal fade" id="addRoom{{ $house->id }}" tabindex="-1">
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
                                         <!-- Delete tolfee Modal -->
                                         <div class="modal fade" id="deletehouse{{ $house->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('houses.destroy', $house->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete House</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6 class="modal-title">Are you sure you want to pemanently delete this house?</h6>
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
                            {{$houses->links('pagination::bootstrap-5')}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Large Modal -->
    <div class="modal fade" id="addHouse" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('houses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New House</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Name:</label>
                            <div class="col-sm-12">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Address:</label>
                            <div class="col-sm-12">
                                <input type="text" name="address" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-12 col-form-label">Description:</label>
                            <div class="col-sm-12">
                                <input type="text" name="description" class="form-control" required>
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
    <!-- End Large Modal-->
</x-app-layout>
