<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Page</title>
    <!-- Include any CSS stylesheets or frameworks you need -->
</head>
<body>
    <!-- Navigation -->
    @include('components.navigation')

    <h1>Reports</h1>

    <!-- Daily Record Table -->
    <h2>Daily Records</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Male Count</th>
                <th>Female Count</th>
                <th>Male Avg Age</th>
                <th>Female Avg Age</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailyRecords as $record)
            <tr>
                <td>{{ $record->date }}</td>
                <td>{{ $record->male_count }}</td>
                <td>{{ $record->female_count }}</td>
                <td>{{ $record->male_avg_age }}</td>
                <td>{{ $record->female_avg_age }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Include any additional content or elements as needed -->

    <!-- Include any JavaScript scripts or frameworks you need -->
</body>
</html>