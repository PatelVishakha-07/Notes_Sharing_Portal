@extends('layouts.admin_layout')

@section('content')

<h3>Admin Dashboard</h3>

<div class="row mt-4">

    <div class="col-md-3">
        <div class="dashboard-card">
            <p>Total Users</p>
            <h4>{{$totalUser}}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="dashboard-card">
            <p>Total Notes</p>
            <h4>{{$totalNotes}}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="dashboard-card">
            <p>Total Categories</p>
            <h4> {{$totalCategory}} </h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="dashboard-card">
            <p>Total Subjects</p>
            <h4> {{$totalSubjects}}  </h4>
        </div>
    </div>

</div>

@endsection