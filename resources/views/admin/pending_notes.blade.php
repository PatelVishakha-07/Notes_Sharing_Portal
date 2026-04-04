@extends('layouts.admin_layout')

@section('content')

<table>
    <tr>
        <th>Notes ID</th>
        <th>User Name</th>
        <th>Category Name</th>
        <th>Subject Name</th>
        <th>File</th>
        <th>Action</th>
    </tr>
    <tr>
        @foreach ($pending_notes as $pn)
            <td>{{$pn->id}}</td>
            <td>{{$pn->user->name}}</td>
            <td>{{$pn->category->cat_name}}</td>
            <td>{{$pn->subject->sub_name}}</td>

            @foreach ($pn->filePath as $fp)
                <td> <a href="{{ asset('storage/'.$fp->file_path) }}" target="_blank" class="btn btn-sm btn-primary"> Open PDF </a> </td>
            @endforeach

            <td>
                <from method="get" action="{{url('')}}">  {{-- AdminController --}}
                    <button type="submit">Approved</button> 
                </from> /
                <from method="get" action="{{url('')}}">  {{-- AdminController --}}
                    <button type="submit">Reject</button> 
                </from>
            </td>
        @endforeach
    </tr>
</table>
    
@endsection