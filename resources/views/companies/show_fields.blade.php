<!-- Name Field -->
<div class="form-group">
    {!! Form::label('Name', 'Name:') !!}
    <p>{{ $company->name }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p><a href="mailto:{{ $company->email }}">{{ $company->email }}</a></p>
</div>

<!-- Logo Id Field -->
<div class="form-group">
    {!! Form::label('logo', 'Logo:') !!}
    <p>
    @if ($company->logo)
    	<img src="{{ asset('storage/'.$company->logo) }}"/>
	@else
		<i>--None--</i>
	@endif
	</p>
</div>

<!-- Website Field -->
<div class="form-group">
    {!! Form::label('website', 'Website:') !!}
    <p><a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer">{{ $company->website }}</a></p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $company->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $company->updated_at }}</p>
</div>

