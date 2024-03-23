@extends('components.layout')
@section('content')
<div class="reports">
    <div class="card">
        <h1>Daily Report</h1>
        <table>
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
                @foreach ($daily_records as $record)
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
    </div>
</div>
@endsection