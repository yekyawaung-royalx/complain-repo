<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Groups</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Case Type</th>
                <th>Main Group</th>
                <th>Number of Complaints</th>
                <th>Messages</th>
            </tr>
        </thead>
        <tbody>
            @forelse($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->case_type_name }}</td>
                    <td>{{ $complaint->main_group }}</td>
                    <td>{{ $complaint->num }}</td>
                    <td>{{ $complaint->messages }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No complaints found for this period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
