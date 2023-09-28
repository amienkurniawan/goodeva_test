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
    <div class="card mb-4 text-white bg-info">
      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-4 fw-semibold"></div>
          <div>On Progress</div>
        </div>
      </div>
      <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas class="chart" id="card-chart2" height="70"></canvas>
      </div>
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
              </tr>
            </thead>
            <tbody>

              @foreach ($project->tasks as $list)
              <tr class="align-middle">
                <td>
                  <div>{{$list->task_name}}</div>
                  <div class="small text-medium-emphasis"><span></span> Start Project: {{$list->start_task}}</div>
                </td>

                <td>
                  <div class="fw-semibold">{{$list->status}}</div>
                </td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <svg class="icon">
                        <use xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-options')}}"></use>
                      </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                        href="http://localhost:8000/project/task/1">Info</a><a class="dropdown-item" href="#">Edit</a><a
                        class="dropdown-item text-danger" href="#">Delete</a>
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

{{ $chart->script() }}
@endsection