<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
	<span class="notice pull-right"><small>* This is a required field</small></span>
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control','maxlength' => 255]) !!}
	<span class="notice pull-right"><small>&nbsp;</small></span>
</div>

<!-- Logo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('logo_file', 'Logo:') !!}
    {!! Form::file('logo_file') !!}
	<span class="notice pull-right"><small>&nbsp;</small></span>
</div>

<!-- Website Field -->
<div class="form-group col-sm-6">
    {!! Form::label('website', 'Website:') !!}
    {!! Form::text('website', null, ['class' => 'form-control','maxlength' => 255]) !!}
	<span class="notice pull-right"><small>&nbsp;</small></span>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('companies.index') }}" class="btn btn-default">Cancel</a>
</div>
