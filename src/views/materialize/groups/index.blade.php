@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Groups
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col l10 m10 s10">
        <h2>Available Groups</h2>
    </div>
    <div class="col l2 m2 s2">
        <a class="btn-floating btn-large waves-effect waves-light red title-button" href="{{ route('sentinel.groups.create') }}"><i class="mdi-content-add"></i></a>
    </div>
</div>
<div class="row">
    <table class="hoverable">
        <thead>
            <th>Name</th>
            <th>Permissions</th>
            <th>Options</th>
        </thead>
        <tbody>
        @foreach ($groups as $group)
            <tr>
                <td><a href="{{ route('sentinel.groups.show', $group->hash) }}">{{ $group->name }}</a></td>
                <td>
                    <?php
                        $permissions = $group->getPermissions();
                        $keys = array_keys($permissions);
                        $last_key = end($keys);
                    ?>
                    @foreach ($permissions as $key => $value)
                        {{ ucfirst($key) . ($key == $last_key ? '' : ', ') }}
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('sentinel.groups.edit', [$group->hash]) }}" class="btn red lighten-1"><i class="mdi-content-create left"></i>Edit</a>
                    <a href="{{ route('sentinel.groups.destroy', [$group->hash]) }}" class="btn action_confirm {{ ($group->name == 'Admins') ? 'disabled' : 'red lighten-1' }}" data-token="{{ Session::getToken() }}" data-method="delete"><i class="mdi-content-remove-circle left"></i>Delete</a>
                 </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    {!! $groups->render() !!}
</div>
<!--
	The delete button uses Resftulizer.js to restfully submit with "Delete".  The "action_confirm" class triggers an optional confirm dialog.
	Also, I have hardcoded adding the "disabled" class to the Admin group - deleting your own admin access causes problems.
-->
@stop

