@extends('layouts.admin')
@section('content')
   <div class="col-md-12" style="padding: 20px;">
      <div class="card card-primary card-outline" style="padding: 20px;">
         <div class="card-header">
            <div class="card-title">Event List</div>
         </div>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">Add Event</a>
    <table class="table table-bordered" id="eventTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Start</th>
                <th>End</th>
                <th>Location</th>
                <th>Seats</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
      </div>
   </div>


<!-- jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>

    
    $('#eventTable').DataTable({
        processing: true,
        serverSide: false, // set true if using yajra or server processing
        ajax: "{{ route('admin.events.list') }}",
        columns: [
            { data: 'id' },
            { data: 'title' },
            { data: 'start_time' },
            { data: 'end_time' },
            { data: 'location' },
            { data: 'total_seats' },
            { data: 'available_seats' },
            {
                data: 'id',
                render: function(data) {
                    return `
                        <a href="/admin/events/${data}/edit" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Delete</button>
                    `;
                }
            },
        ]
    });

    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        if(confirm("Are you sure?")) {
            $.ajax({
                url: `/admin/events/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            msg: 'Event Successfully Deleted'
                    });
                    setTimeout(function(){
                            location.reload();
                    }, 2000);
                }
            });
        }
    });

</script>

@endsection