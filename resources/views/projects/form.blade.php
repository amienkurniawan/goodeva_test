@extends ('layouts.master')

@section('content')

{{-- PROJECT LIST --}}
<!-- /.row-->
<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-header">Projects</div>
      <div class="card-body">
        <form method="post" action="{{ route('save.project') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="mb-3">
            <label for="project_name" class="form-label">Project Name</label>
            <input type="text" name="project_name" class="form-control" id="project_name" placeholder="Project name">
          </div>
          <div class="mb-3 col-md-3">
            <label for="start_project" class="form-label">Start Date</label>
            <input type="date" name="start_project" class="form-control" id="start_project" placeholder="Date start">
          </div>
          <div class="mb-3 col-md-3">
            <label for="end_project" class="form-label">End Date</label>
            <input type="date" name="end_project" class="form-control" id="end_project" placeholder="Date end">
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