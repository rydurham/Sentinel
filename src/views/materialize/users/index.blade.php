@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Current Users
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col l10 m10 s10">
        <h2>Current Users</h2>
    </div>
    <div class="col l2 m2 s2">
        <a class="btn-floating btn-large waves-effect waves-light red title-button" href="{{ route('sentinel.users.create') }}"><i class="mdi-content-add"></i></a>
    </div>
</div>

<div class="row">
    <table class="hoverable">
        <thead>
            <th>User</th>
            <th>Status</th>
            <th>Options</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>
                        <a href="{{ route('sentinel.users.show', array($user->hash)) }}">{{ $user->email }}</a>
                    </td>
                    <td>
                        {{ $user->status }}
                    </td>
                    <td>
                        <button type="button" onClick="location.href='{{ route('sentinel.users.edit', array($user->hash)) }}'" class="btn red lighten-1"><i class="mdi-content-create left"></i>Edit</button>
                        @if ($user->status != 'Suspended')
                            <button type="button" onClick="location.href='{{ route('sentinel.users.suspend', array($user->hash)) }}'" class="btn red lighten-1">Suspend</button>
                        @else
                            <button type="button" onClick="location.href='{{ route('sentinel.users.unsuspend', array($user->hash)) }}'" class="btn red lighten-1">Un-Suspend</button>
                        @endif
                        @if ($user->status != 'Banned')
                            <button type="button" onClick="location.href='{{ route('sentinel.users.ban', array($user->hash)) }}'" class="btn red lighten-1">Ban</button>
                        @else
                            <button type="button" onClick="location.href='{{ route('sentinel.users.unban', array($user->hash)) }}'" class="btn red lighten-1">Un-Ban</button>
                        @endif
                        <button class="btn red lighten-1 action_confirm" href="{{ route('sentinel.users.destroy', array($user->hash)) }}" data-token="{{ Session::getToken() }}" data-method="delete"><i class="mdi-content-remove-circle left"></i>Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {!! $users->render() !!}
</div>
@stop
