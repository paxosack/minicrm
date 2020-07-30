<div class="table-responsive">
    <table class="table" id="companies-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Email</th>
        <th>Logo</th>
        <th>Website</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($companies as $company)
            <tr>
            <td>{{ $company->name }}</td>
            <td><a href="mailto:{{ $company->email }}">{{ $company->email }}</a></td>
            <td>
            @if ($company->logo)
            	<img src="{{ asset('storage/'.$company->logo) }}" style="max-width:100px;max-height:100px">
        	@else
        		<i>--None--</i>
        	@endif
        	</td>
            <td><a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer">{{ $company->website }}</a></td>
                <td>
                    {!! Form::open(['route' => ['companies.destroy', $company->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('companies.show', [$company->id]) }}" class='btn btn-default btn-xs open'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('companies.edit', [$company->id]) }}" class='btn btn-default btn-xs edit'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs trash', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
