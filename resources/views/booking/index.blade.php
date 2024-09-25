@extends('layouts.main')

@section('content')
    <div class="container p-5">
        <h1 class="text-center">Online Bus Booking System</h1>
        <form action="{{route('booking.select_seats')}}" method="post">
            @csrf
            <div class="form-group">
              <label for="from">From</label>
              <select class="form-control" id="from" name="from">
                <option value="">Select City</option>
                
                    @foreach($locations as $key => $value) 
                        <option value="{{ $value->name}}">{{ $value->name }}</option>
                    
                    @endforeach
                
              </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">To</label>
                <select class="form-control" id="to" name="to">
                  <option>Select City</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleFormControlSelect1">Seat Type</label>
                <select class="form-control" id="seat_type" name="seat_type">
                  <option value="">Select Seat</option>
                  <option value="Single">Single Seat</option>
                  <option value="Double">Double Seat</option>
                </select>
              </div>




              <div>
                <input type="submit" class="btn btn-primary" name="Submit" value="Book">
              </div>
              @foreach ($routes as $route)
              <input type="hidden" name="route_id" id="route_id" value="{{$route->id}}">
              @endforeach
          </form>
          
          <div class="container mt-5">
            <h3 class="text-center">Booking Information</h3>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                    <th scope="col">Seat Type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Seat No.</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mumbai</td>
                    <td>Pune</td>
                    <td>Single</td>
                    <td>Booked</td>
                    <td>12</td>
                    <td></td>
                  </tr>
                </tbody>
              </table>

          </div>
    </div>


@endsection
  
@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $('#from').on('change', function(){
            $("#to").html('');
            $("#to").html(' <option>Select City</option>');
            $.ajax({
                type: "POST",
                url: "{{ route('getLocation') }}",
                data: { _token: '{{ csrf_token() }}', from: $(this).val() },
                success: function(response) {
                    var result = JSON.parse(response);
                    result.forEach(function(location) {
                        $("#to").append('<option value="'+location.name+'">'+location.name+'</option>');
                        
                    });
                    
                }
            });
        })
    </script>
    
@endpush