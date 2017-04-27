	{{-- 新規TODO入力欄 --}}
	<div class="row">
		<div class="col-sm-12 col-md-6">
			{{ Form::open(['url' => route('todos.store'), 'method' => 'POST']) }}
				<div class="form-group {{ count($errors) > 0 ? 'has-error' : '' }}">
					<div class="input-group">
						<input type="text" name="title" value="{{ old('title') }}" placeholder="何をする？" class="form-control">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> 追加</button>
						</span>
					</div>
@if (count($errors) > 0)
					<div class="alert alert-danger">
					    <ul>
					        @foreach ($errors->all() as $error)
					            <li>{{ $error }}</li>
					        @endforeach
					    </ul>
					</div>
@endif
				</div>
			{{ Form::close() }}
		</div>
	</div>
