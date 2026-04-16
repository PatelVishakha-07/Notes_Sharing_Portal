@extends("layouts.admin_layout")

@section("content")

<div class="container mt-3">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">👥 Users List</h3>
    </div>

    

    <!-- TABLE -->
     <div class="card shadow-sm border-0">

    <div class="card-body">

        <!-- SEARCH -->
        <form method="GET" class="mb-3" action="{{url('admin/showUsersList')}}">
            <div class="input-group input-group-sm" style="max-width: 350px;">
                <input type="text" name="search"
                       class="form-control" placeholder="Search name or email..." value="{{request('search')}}">

                <button class="btn btn-outline-primary" type="submit"> Search </button>
            </div>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center mb-0">

                <thead>
                    <tr style="background: #f1f5f9;">
                        <th class="py-3 fw-semibold text-uppercase text-muted small border-0"> User ID </th>

                        <th class="py-3 fw-semibold text-uppercase text-muted small border-0"> User Name </th>

                        <th class="py-3 fw-semibold text-uppercase text-muted small border-0"> Email </th>

                        <th class="py-3 fw-semibold text-uppercase text-muted small border-0"> Status </th>

                        <th class="py-3 fw-semibold text-uppercase text-muted small border-0"> Notes </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted"> {{ $user->id }} </td>

                        <td class="fw-medium"> {{ $user->name }} </td>

                        <td class="text-muted"> {{ $user->email }} </td>

                        <td>
                            @if($user->status == 1)
                                <span class="text-success fw-semibold">Active</span>
                            @else
                                <span class="text-danger fw-semibold">Inactive</span>
                            @endif
                        </td>

                        <td class="text-dark">
                            {{ $user->notes_count ?? 0 }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted py-4">
                            No users found
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
</div>

</div>

<div class="d-flex justify-content-center mt-3">
    {{-- {{ $users->links() }} --}}
    {{ $users->appends(request()->query())->links() }}
</div>

@endsection