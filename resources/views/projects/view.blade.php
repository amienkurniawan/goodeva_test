@extends ('layouts.master')

@section('content')

<div class="row">
  <div class="col-sm-6 col-lg-6">
    <div class="card mb-4 text-white bg-white">
      {!! $chart->container() !!}
    </div>
  </div>
  <!-- /.col-->
  <div class="col-sm-6 col-lg-6">
    <div class="card mb-4 text-white bg-white">
      {!! $piechart->container() !!}
    </div>
  </div>
</div>
<!-- /.row-->

{{-- PROJECT LIST --}}
<!-- /.row-->
<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-header">Tasks</div>
      <div class="card-body">
        <!-- /.row--><br>
        <div class="table-responsive">
          <table class="table border mb-0">
            <thead class="table-light fw-semibold">
              <tr class="align-middle">
                <th>Tasks</th>
                <th>Status</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>

              @foreach ($project->tasks as $list)
              <tr class="align-middle">
                <td>
                  <div>{{$list->task_name}}</div>
                  <div class="small text-medium-emphasis"><span></span> Start Task: {{$list->start_task}}</div>
                </td>
                <td>
                  <div class="fw-semibold">{{$list->status}}</div>
                </td>
                <form action="{{route('project.task.update.status',['id'=>$list->id])}}" method="post">
                  @method('patch')
                  @csrf
                  <td>
                    <div class="dropdown">
                      <select class="form-select" name="status" aria-label="Default select example">
                        <option value="on progress" {{ old('status')=='on progress' ? 'selected' : '' }} {{$list->status
                          == "on progress" ? 'selected':''}}>On Progress
                        </option>
                        <option value="finish" {{ old('status')=='finish' ? 'selected' : '' }} {{$list->status ==
                          "finish" ? 'selected':''}}>Finish</option>
                        <option value="delay" {{ old('status')=='delay' ? 'selected' : '' }} {{$list->status == "delay"
                          ? 'selected':''}}>Delay</option>
                      </select>
                    </div>
                  </td>
                  <td>
                    <button type="submit" class="btn btn-primary" type="button">Update</button>
                  </td>
                </form>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.col-->
</div>
<!-- /.row-->
<script src="{{ $chart->cdn() }}"></script>
<script src="{{ $piechart->cdn() }}"></script>

{{ $chart->script() }}
{{ $piechart->script() }}
@endsection