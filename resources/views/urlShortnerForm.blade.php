@include('sidebar')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortner</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">URL Shortner</div>
                    @if(session()->has('message'))

                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="card-body">
                        <!-- Laravel Form -->

                        <form id="urlShortenerForm" method="POST" action="{{ $data ? url('updateURLForm') : url('createShortner') }}">
                            @csrf

                            <!-- Input Field -->
                            <div class="mb-3">
                                <label for="inputField" class="form-label">{{$data ? 'Update URL' : 'Add URL'}}</label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="Enter something" value="{{$data ? $data->destination_url : ''}}">
                            </div>
                            <input type="hidden" id="dataId" value="{{$data ? $data->id : ''}}">

                            <!-- Submit Button -->
                            <button id="shortenBtn" class="btn btn-primary">Submit</button>
                        </form>
                        <!-- End Laravel Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.getElementById('urlShortenerForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Fetch API to make an Ajax request
            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        url: document.getElementById('url').value,
                        id: document.getElementById('dataId').value,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                   alert(data.data);
                   document.getElementById('url').value = '';

                })
                .catch(error => {
                    alert(error);
                });
        });
    </script>

</body>

</html>