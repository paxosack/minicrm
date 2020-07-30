<div class="table-responsive">
    <table class="table" id="employees-table">
        <thead>
            <tr>
                <th>First Name</th>
        <th>Last Name</th>
        <th>Company</th>
        <th>Email</th>
        <th>Phone</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->first_name }}</td>
            <td>{{ $employee->last_name }}</td>
            <td><a href="{{ route('companies.show', [$employee->company_id])}}">
            	@if ($employee->company->logo)
            	<img src="{{ asset('storage/'.$employee->company->logo) }}" style="max-width:32px;max-height:32px">
            	@endif
            	{{ $employee->company->name }}</a>
        	</td>
            <td><a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a></td>
            <td>{{ $employee->phone }}</td>
                <td>
                    {!! Form::open(['route' => ['employees.destroy', $employee->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('employees.show', [$employee->id]) }}" class='btn btn-default btn-xs open'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('employees.edit', [$employee->id]) }}" class='btn btn-default btn-xs edit'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs trash', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
