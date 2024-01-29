<!-- resources/views/upgrade/upgrade_form.blade.php -->
@include('sidebar')


<body class="bg-light">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-8">
                <div class="card">
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

                        <h3 class="card-title mb-4">Upgrade Your Plan</h3>

                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <form method="post" action="{{ route('upgradePlan') }}">
                            @csrf

                            <div class="form-group">
                                <label for="selected_plan">Do you want to upgrade your plan from 10 to 1000 short URLs:</label>
                                <select id="selected_plan" name="selected_plan" class="form-control" required>
                                    <option value="" disabled selected hidden>Select value</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>

                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Upgrade Plan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>