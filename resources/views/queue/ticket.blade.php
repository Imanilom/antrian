@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3>Queue Ticket</h3>
        <p>Loket: {{ $queue->loket }}</p>
        <p>Number: {{ $queue->number }}</p>
        <p>Code: {{ $queue->code }}</p>
        <p>Status: {{ $queue->status }}</p>

        <a href="{{ route('home') }}" class="btn btn-primary">Back to Loket Selection</a>
    </div>
@endsection
