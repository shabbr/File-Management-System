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
       <form action="{{ route('moveFile') }}" method="post">
        @csrf
        <label> file name :</label>
        <select name="file" id="" required class='form-control'>
              <option value="{{ $file->id  }}">{{ $file->stored_name  }}</option>
          </select> <br>
        <label>From this folder:</label>
      <select name="folder1" id="folder1" required class='form-control'>
            <option value="{{ $file->folder->id }}">{{ $file->folder->full_path }}</option>
        </select>
      <br>
      <label>To this folder:</label>
      <select name="folder2" id="folder2" required class='form-control'>
            @foreach ($folders as $folder)
            <option value="{{ $folder->id }}">{{ $folder->full_path }}</option>
       @endforeach
        </select> <br>
        <button class="btn btn-primary" type="submit" style="margin-top: 3px;">Move File</button> <br>
    </form>

    <div id="foldersList"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


</body>
</html>
