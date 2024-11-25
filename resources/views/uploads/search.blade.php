@if(isset($searchTerm) && $uploads->isNotEmpty())
    <h3 class="mb-3">Search results for: <strong>{{ $searchTerm }}</strong></h3>
    <div class="list-group">
        @foreach($uploads as $upload)
            <a href="{{ asset('storage/'.$upload->path)}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $upload->original_name }}</strong>
                    <small class="d-block text-muted">{{ $upload->path }}</small>
                    <small class="d-block text-muted">Folder: {{ $upload->folder->name ?? 'N/A' }}</small>
                </div>
                <span class="badge {{ $upload->mime_type ? 'bg-info' : 'bg-secondary' }} rounded-pill">
                    {{ $upload->mime_type }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $uploads->links() }}
    </div>
@elseif(isset($searchTerm) && $uploads->isEmpty())
    <div class="alert alert-info">
        No results found for "<strong>{{ $searchTerm }}</strong>". Please try again with different keywords.
    </div>
@endif
