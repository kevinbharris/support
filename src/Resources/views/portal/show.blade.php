<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #{{ $ticket->ticket_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <h2>Ticket #{{ $ticket->ticket_number }}</h2>
                    </div>
                    <div class="card-body">
                        <h4>{{ $ticket->subject }}</h4>
                        <p><strong>Status:</strong> 
                            <span class="badge" style="background-color: {{ $ticket->status->color }}">
                                {{ $ticket->status->name }}
                            </span>
                        </p>
                        <p><strong>Priority:</strong> 
                            <span class="badge" style="background-color: {{ $ticket->priority->color }}">
                                {{ $ticket->priority->name }}
                            </span>
                        </p>
                        <p><strong>Category:</strong> {{ $ticket->category->name }}</p>
                        <p><strong>Created:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
                        <hr>
                        <h5>Description</h5>
                        <p>{{ $ticket->description }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Conversation</h4>
                    </div>
                    <div class="card-body">
                        @foreach($ticket->notes as $note)
                            <div class="note mb-3 p-3 bg-light rounded">
                                <div class="note-header mb-2">
                                    <strong>{{ $note->created_by_name }}</strong>
                                    <span class="text-muted float-end">{{ $note->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="note-content">
                                    {{ $note->content }}
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        <form action="{{ route('support.portal.reply', $ticket->access_token) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="content" class="form-label">Add Reply</label>
                                <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Reply</button>
                        </form>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-muted">Bookmark this page to access your ticket anytime.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
