<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
   
</head>
<body class="col-8 mx-auto shadow p-5">
    @if(session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <h1>Upload Files</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
        <ul>
            @foreach(session('files') as $file)
                <li>{{ $file }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="files">Choose files to upload (multiple allowed):</label> <br>
        <input type="file" name="files[]" id="files" multiple required>
        @error('files.*')
            <div style="color: red;">{{ $message }}</div>
        @enderror
        <br>
        <label for="">Folder Path</label> <br>
        <select name="folder_id" id="path" required style="width: 13%;">
            {{-- <option value="" selected  >/root</option> --}}
            @foreach ($paths as $path)
                 <option value="{{ $path->id }}">{{ $path->full_path }}</option>
            @endforeach
        </select>
        @error('full_path')
          <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>
        <button type="submit">Upload Files</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    if ($('#success-alert').length) {
            setTimeout(function() {
                $('#success-alert').fadeOut();
            }, 3000);  
        }
    });
</script>
</body>
</html>
