<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Contact Support</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('support.portal.submit') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Your Name *</label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Your Email *</label>
                                <input type="email" name="customer_email" id="customer_email" class="form-control" value="{{ old('customer_email') }}" required>
                                @error('customer_email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject *</label>
                                <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(config('support.recaptcha_enabled') && config('support.recaptcha_site_key'))
                                <div class="mb-3">
                                    <div class="g-recaptcha" data-sitekey="{{ config('support.recaptcha_site_key') }}"></div>
                                    @error('g-recaptcha-response')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                            @endif

                            <button type="submit" class="btn btn-primary">Submit Ticket</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
