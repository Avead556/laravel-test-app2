@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Currency Rates</h1>

        @if(isset($currencies['rates']))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Currency</th>
                    <th>Rate</th>
                </tr>
                </thead>
                <tbody>
                @foreach($currencies['rates'] as $currency => $rate)
                    <tr>
                        <td>{{ $currency }}</td>
                        <td>{{ $rate }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No currency rates available</p>
        @endif
    </div>
@endsection
