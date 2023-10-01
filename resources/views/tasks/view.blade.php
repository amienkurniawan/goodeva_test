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


        <div class="row">
          <div class="col-md-2">
            <a href="{{route('project.task.create',['id'=>$project->id])}}" class="btn btn-primary" type="button">Create
              Task</a>
          </div>
        </div>
        <!-- /.row--><br>
        <div class="table-responsive">
          <table class="table border mb-0">
            <thead class="table-light fw-semibold">
              <tr class="align-middle">
                <th>Tasks</th>
                <th>Status</th>
                <th></th>
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

                    <select class="form-select" name="status" aria-label="Default select example">
                      <option value="on progress" {{ old('status')=='on progress' ? 'selected' : '' }} {{$list->status
                        == "on progress" ? 'selected':''}}>On Progress
                      </option>
                      <option value="finish" {{ old('status')=='finish' ? 'selected' : '' }} {{$list->status ==
                        "finish" ? 'selected':''}}>Finish</option>
                      <option value="delay" {{ old('status')=='delay' ? 'selected' : '' }} {{$list->status == "delay"
                        ? 'selected':''}}>Delay</option>
                    </select>

                  </td>
                  <td>
                    <button type="submit" class="btn btn-primary" type="button">Update</button>
                  </td>
                </form>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <svg class="icon">
                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                      </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item" href="{{route('project.task.edit',['id'=>$list->id])}}">Edit</a>
                      <form action="{{route('project.task.delete',['id'=>$list->id])}}" method="post">
                        {{ csrf_field() }}
                        @method('delete')
                        <button class="dropdown-item text-danger" type="submit">Delete</button>
                      </form>
                    </div>
                  </div>
                </td>

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