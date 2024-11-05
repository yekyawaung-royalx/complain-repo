<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Groups</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Branches in City ID 1</h1>
        @if ($group1)
            <ul class="list-group mb-4">
                @foreach ($group1 as $branch)
                    <li class="list-group-item">
                        <strong>Branch Name:</strong> {{ $branch->branch }}<br>
                        <strong>Branch ID:</strong> {{ $branch->branch_id }}<br>
                        <strong>City Name:</strong> {{ $branch->city_name }}<br>
                        <strong>City ID:</strong> {{ $branch->city_id }}<br>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No branches found for City ID 1.</p>
        @endif

        <h1>Other City Groups</h1>
        @if ($otherGroups->isNotEmpty())
            @foreach ($otherGroups as $cityId => $branches)
                <h2>City ID: {{ $cityId }}</h2>
                <ul class="list-group mb-4">
                    @foreach ($branches as $branch)
                        <li class="list-group-item">
                            <strong>Branch Name:</strong> {{ $branch->branch }}<br>
                            <strong>Branch ID:</strong> {{ $branch->branch_id }}<br>
                            <strong>City Name:</strong> {{ $branch->city_name }}<br>
                            <strong>City ID:</strong> {{ $branch->city_id }}<br>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        @else
            <p>No branches found in other cities.</p>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
