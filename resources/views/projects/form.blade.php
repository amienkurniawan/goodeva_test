@extends ('layouts.master')

@section('content')

{{-- PROJECT LIST --}}
<!-- /.row-->
<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-header">Projects</div>
      <div class="card-body">

        @if ($edit =='true')
        <form method="post" action="{{ route('update.project',['id'=>$data->id]) }}" enctype="multipart/form-data">
          @method('PUT')
          @else
          <form method="post" action="{{ route('save.project') }}" enctype="multipart/form-data">
            @endif
            {{ csrf_field() }}

            <div class="mb-3">
              <label for="project_name" class="form-label">Project Name</label>
              <input type="text" value="{{ old('project_name',isset($data->project_name) ? $data->project_name :'') }}"
                name="project_name" class="form-control @error('project_name') is-invalid @enderror" id="project_name"
                placeholder="Project name">

              @error('project_name')
              <div id="" class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
              @enderror

            </div>
            <div class="mb-3 col-md-3">
              <label for="start_project" class="form-label">Start Date</label>
              <input type="date" name="start_project"
                value="{{ old('start_project',isset($data->start_project) ? date('Y-m-d',strtotime($data->start_project)):'' ) }}"
                class="form-control  @error('start_project') is-invalid @enderror" id="start_project"
                placeholder="Date start">

              @error('start_project')
              <div id="" class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
              @enderror

            </div>

            <div class="mb-3 col-md-3">
              <label for="end_project" class="form-label">End Date</label>
              <input type="date" name="end_project"
                value="{{ old('end_project',isset($data->end_project) ? date('Y-m-d',strtotime($data->end_project)):'' ) }}"
                class="form-control @error('end_project') is-invalid @enderror" id="end_project" placeholder="Date end">

              @error('end_project')
              <div id="" class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
              @enderror

            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{route('index.project')}}" class="btn btn-secondary">Cancel</a>
          </form>
      </div>
    </div>
  </div>
  <!-- /.col-->
</div>
<!-- /.row-->

@endsection