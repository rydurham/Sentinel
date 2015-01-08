@extends(Config::get('Sentinel::views.layout'))

{{-- Web site Title --}}
@section('title', 'Add User')

{{-- Content --}}
@section('content')

<div class="row">

        {{ Form::open(array('action' => 'Sentinel\UserController@store')) }}
    
        <ul class="centered six columns">
        <h4>Add New User</h4>

        <li class="field {{ ($errors->has('email')) ? 'danger' : '' }}">
            <input type="text" name='email' placeholder="E-mail" class="text input" value="{{ Request::old('email') }}">
        </li>
        {{ $errors->first('email',  '<p class="form_error">:message</p>') }}
        
        <li class="field {{ $errors->has('password') ? 'danger' : '' }}">
            <input type="password" name="password" placeholder="Password" class="password input">
        </li>
        {{ $errors->first('password',  '<p class="form_error">:message</p>') }}
        
        <li class="field {{ $errors->has('password_confirmation') ? 'danger' : '' }}">
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="password input">
        </li>
        {{ $errors->first('password_confirmation',  '<p class="form_error">:message</p>') }}

        <li class="field">
            <label for="activate" class="checkbox">
                <input type="checkbox"  name="activate">
                <span></span> Activate
            </label>
        </li>

         @if ( Sentry::getUser()->isSuperUser() )
            <label id="blocklabel" class="label info">Organization</label>
            <li class="field">
                <div class="picker">
                    {{ Form::select('org_id', $allOrgs); }}
                </div>
            </li>

            <h4>Group Memberships</h4>
            @foreach ($allGroups as $group)
                <li class="field">
                    <label for="permissions[{{ $group->id }}]" class="checkbox">
                      <input type="checkbox"  name="permissions[{{ $group->id }}]">
                      <span></span> {{ $group->name }}
                    </label>
                </li>
            @endforeach
        @endif    

        <div class="medium primary btn"><input type="submit" value="Add User"></div>
        <div class="medium default btn"><input type="reset" value="Reset"></div> 
        </ul>

	</form>
</div>


@stop