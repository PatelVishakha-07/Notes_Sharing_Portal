@extends('layouts.user_layout')

@section('content')


<h3>Welcome, {{ auth()->user()->name }}</h3>
<p>Manage your notes and uploads</p>

<div class="row mt-4">

    <div class="col-md-4">
        <div class="dashboard-card">
            <p>My Notes</p>
            <h4>10</h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="dashboard-card">
            <p>Public Notes</p>
            <h4>10</h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="dashboard-card">
            <p>Private Notes</p>
            <h4>10</h4>
        </div>
    </div>

</div>

<div class="mt-4">
    <a href="{{url('user/upload_notes')}}" class="btn btn-primary">Upload Note</a> 
    <a href="/my_notes" class="btn btn-secondary">View My Notes</a>
</div>


{{-- 
<h5 class="mt-4">Recent Uploads</h5>

<ul>
@foreach($recentNotes as $note)
    <li>{{ $note->title }}</li>
@endforeach
</ul> --}}

@endsection