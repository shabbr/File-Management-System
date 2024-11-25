<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="col-8 mx-auto shadow p-5">
    @if(session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form id="searchForm">
    @csrf
    <input type="text" name="query" id="searchInput" placeholder="Search" required class="form-control">
</form>
<br>
<div id="searchResults"></div>
    <form action="{{ route('folders.store') }}" method="post">
        @csrf
        <label for="">Folder Name:</label>
        <input type="text" name="name" id='name' placeholder="Folder Name"  required style="" class='form-control'>
        <span id="message" style="color:red;"></span>
      <br>
      <label for="">Folder Path:</label>
      <select name="path" id="path" required style="" class='form-control'>
            <option value="root" selected>/root</option>
            @foreach ($paths as $path)
                 <option value="{{ $path->full_path }}">{{ $path->full_path }}</option>
            @endforeach
        </select> <br>
        <button class="btn btn-primary" type="submit">Create Folder</button> <br>
    </form>
<br>
    <h3>List of folders</h3>
    <div id="foldersList"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

   <script>

$(document).ready(function() {
        function loadFolders() {
            $.get(`/folders`, function(data) {
                const folders = data.folders;
                $('#foldersList').empty();
                folders.forEach(folder => {
                    console.log(folder.path);
                    let folderUrl = `{{ route('folders.show', ['path' => '__PATH__', 'name' => '__NAME__']) }}`
                      .replace('__PATH__', folder.path)
                      .replace('__NAME__', folder.name);
                    $('#foldersList').append(`<div>${folder.name} <a href="${folderUrl}">View</a></div>`);
                });
            });
        }
loadFolders();
if ($('#success-alert').length) {
            setTimeout(function() {
                $('#success-alert').fadeOut();
            }, 3000);
        }
    });


    $('#searchForm').on('keyup', function(event) {
            event.preventDefault();
            let query = $('#searchInput').val();
            $.ajax({
                url: '{{ route('uploads.search') }}',
                type: 'GET',
                data: {
                    query: query,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                $('#searchResults').html(response);
                    $('#searchResults').html(response.html);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ': ' + error);
                    $('#searchResults').html('<div class="alert alert-danger">An error occurred. Please try again later.</div>');
                }
            });
        });

    </script>
</body>
</html>
