@extends ('layouts.master')

@section('content')

{{-- PROJECT LIST --}}
<!-- /.row-->
<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-header">Tasks</div>
      <div class="card-body">

        @if ($edit =='true')
        <form method="post" action="{{ route('project.task.update',['id'=>$data->id]) }}">
          @method('PUT')
          @else
          <form method="post" action="{{ route('project.task.store',['id'=>$project_id]) }}">
            @endif
            {{ csrf_field() }}

            <div class="mb-3">
              <label for="task_name" class="form-label">Task Name</label>
              <input type="text" value="{{ old('task_name',isset($data->task_name) ? $data->task_name :'') }}"
                name="task_name" class="form-control @error('task_name') is-invalid @enderror" id="task_name"
                placeholder="Task name">

              @error('task_name')
              <div id="" class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
              @enderror

            </div>
            <div class="mb-3 col-md-3">
              <label for="start_task" class="form-label">Start Date</label>
              <input type="date" name="start_task"
                value="{{ old('start_task',isset($data->start_task) ? date('Y-m-d',strtotime($data->start_task)):'' ) }}"
                class="form-control  @error('start_task') is-invalid @enderror" id="start_task"
                placeholder="Date start">

              @error('start_task')
              <div id="" class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
              @enderror

            </div>

            <div class="mb-3 col-md-3">
              <label for="end_task" class="form-label">End Date</label>
              <input type="date" name="end_task"
                value="{{ old('end_task',isset($data->end_task) ? date('Y-m-d',strtotime($data->end_task)):'' ) }}"
                class="form-control @error('end_task') is-invalid @enderror" id="end_task" placeholder="Date end">

              @error('end_task')
              <div id="" class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
              @enderror

            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{route('project.task.show',['id'=>$project_id])}}" class="btn btn-secondary">Cancel</a>
          </form>
      </div>
    </div>
  </div>
  <!-- /.col-->
</div>
<!-- /.row-->

@endsection