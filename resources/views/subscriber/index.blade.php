<!DOCTYPE html>
<html>
<head>
    <title>Mailerlite</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
</head>
<body>

    <div class="container mt-5">

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
    @endif

    @if(Session::has('invalid'))
        <div class="alert alert-danger">
            {{Session::get('invalid')}}
        </div>
    @endif
    
<div class="container mt-5">
    <h2 class="mb-4">Mailerlite</h2>

    <table id="subscriberTable" class="display">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Subscribed Date</th>
            <th>Subscribed Time</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


</div>
   
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
    // datatable implementation
    $('#subscriberTable').DataTable({
        data: response.data,
        columns: [
            { 
                title: 'email', 
                data: 'email',
                render: function(data, type, row) {
                    const id = row.id;
                    const editUrl = `/subscriber/${id}/edit`;
                    return `<a href="${editUrl}" data-id="${id}">${data}</a>`;
                }
            },
            { title: 'name', data: 'name'},
            { title: 'country', data: 'country' },
            {
                title: 'subscribed_at',
                data: 'subscribed_at',
                render: function(data) {
                    const date = new Date(data);
                    const day = date.getDate().toString().padStart(2, '0'); 
                    const month = (date.getMonth() + 1).toString().padStart(2, '0'); 
                    const year = date.getFullYear().toString();
                    return `${day}/${month}/${year}`;        
                }
            },
            {
                title: 'subscribed_time',
                data: 'subscribed_at',
                render: function(data) {
                    const date = new Date(data);
                    const hours = date.getHours().toString().padStart(2, '0'); 
                    const minutes = date.getMinutes().toString().padStart(2, '0'); 
                    const seconds = date.getSeconds().toString().padStart(2, '0');
                    return `${hours}:${minutes}:${seconds}`;
                    }
            },
            {
                title: 'actions',
                data: 'id',
                render: function(data, type, row) {
                    const id = row.id;
                    return `<button class="btn btn-danger delete-btn" data-id="${id}">Delete</button>`
                }
            }
          
        ],
        paging: true,
        pageLength: response.meta.per_page,
        info: true,
        ordering: true
    });

    // Handle the Previous button click
    $('#subscriberTable_previous').on('click', function() {
        if (response.links.prev) {
        $.ajax({
            url: response.links.prev,
            beforeSend: function(xhr) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + '{{ \App\Models\Account::first()->api_key }}');
            },
            success: function(data) {
            response = data;
            table.clear().rows.add(response.data).draw();
            }
        });
        }
    });

    // Handle the Next button click
    $('#subscriberTable_next').on('click', function() {
    if (response.links.next) {
        $.ajax({
        url: response.links.next,
        beforeSend: function(xhr) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + '{{ \App\Models\Account::first()->api_key }}');
        },
        success: function(data) {
            response = data;
            table.clear().rows.add(response.data).draw();
        }
        });
    }
    });

    // handle delete button
    $('.delete-btn').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
        url: '/subscriber/' + id,
        type: 'DELETE',
        success: function(response) {
            // Reload the datatable
            $('#subscriberTable').DataTable().ajax.reload();
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
        });
    });

    // Add a change event listener to the per page length select input
    $('#subscriberTable_length select').on('change', function() {
        var perPageLength = $(this).val();
        
        $.ajax({
        url: `${response.meta.path}?limit=${perPageLength}`,
        beforeSend: function(xhr) {
            xhr.setRequestHeader('Authorization', 'Bearer ' + '{{ \App\Models\Account::first()->api_key }}');
        },
        success: function(data) {
            response = data;
            dataTable.clear().rows.add(data).draw();
        }
        });
    });
});
</script>
</html>