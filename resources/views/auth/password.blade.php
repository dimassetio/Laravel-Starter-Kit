@extends('layouts.guest')

@section('content')
<div class="col-md-4 col-md-offset-4">
	<div class="login-panel panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Reset Password</h3></div>
		<div class="panel-body">
            @include('auth.partials._notifications')
			{!! Form::open(['route'=>'auth.forgot-password']) !!}
            {!! FormField::email('email') !!}
            {!! Form::submit('Send Password Reset Link', ['class'=>'btn btn-success btn-block']) !!}
            {!! link_to_route('auth.login','Back to Login', [],['class'=>'btn btn-default btn-block']) !!}
            {!! Form::close() !!}
		</div>
    </div>
		@include('layouts.partials.footer')
</div>
@endsection
