@extends ('layouts.master')

@section('content')

<div class="row">
  <div class="col-sm-6 col-lg-3">
    <div class="card mb-4 text-white bg-primary">
      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-4 fw-semibold">{{$total_project}}</div>
          <div>Total Projects</div>
        </div>
      </div>
      <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas class="chart" id="card-chart1" height="70"></canvas>
      </div>
    </div>
  </div>
  <!-- /.col-->
  <div class="col-sm-6 col-lg-3">
    <div class="card mb-4 text-white bg-info">
      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-4 fw-semibold">{{$onprogress_project}}</div>
          <div>On Progress</div>
        </div>
      </div>
      <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas class="chart" id="card-chart2" height="70"></canvas>
      </div>
    </div>
  </div>
  <!-- /.col-->
  <div class="col-sm-6 col-lg-3">
    <div class="card mb-4 text-white bg-warning">
      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-4 fw-semibold">{{$finish_project}}</div>
          <div>Completed</div>
        </div>
      </div>
      <div class="c-chart-wrapper mt-3" style="height:70px;">
        <canvas class="chart" id="card-chart3" height="70"></canvas>
      </div>
    </div>
  </div>
  <!-- /.col-->
  <div class="col-sm-6 col-lg-3">
    <div class="card mb-4 text-white bg-danger">
      <div class="card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
          <div class="fs-4 fw-semibold">{{$delay_project}}</div>
          <div>Delay</div>
        </div>
      </div>
      <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas class="chart" id="card-chart4" height="70"></canvas>
      </div>
    </div>
  </div>
  <!-- /.col-->
</div>
<!-- /.row-->

{{-- PROJECT LIST --}}
<!-- /.row-->
<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <div class="card-header">Projects</div>
      <div class="card-body">
        <div class="col-auto">
          <div class="row">
            <div class="col-md-2">
              <a href="{{route('create.project')}}" class="btn btn-primary" type="button">Create Project</a>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-4">
              <a href="{{route('export.pdf.project')}}" class="btn btn-info" type="button">Export PDF</a>
              <a href="{{route('export.project')}}" class="btn btn-primary">Export Excel</a>
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-light" data-coreui-toggle="modal" data-coreui-target="#exampleModal">
                Import Project
              </button>
            </div>
          </div>
        </div>
        <!-- /.row--><br>
        <div class="table-responsive">
          <table class="table border mb-0">
            <thead class="table-light fw-semibold">
              <tr class="align-middle">
                <th>Projects</th>
                <th>Progress</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($list_projects as $list)
              <tr class="align-middle">
                <td>
                  <div>{{$list->project_name}}</div>
                  <div class="small text-medium-emphasis"><span></span> Start Project: {{$list->start_project}}</div>
                </td>
                <td>
                  <div class="clearfix">
                    <div class="float-start">
                      <div class="fw-semibold">50%</div>
                    </div>
                    <div class="float-end"><small class="text-medium-emphasis">Jun 11, 2020 - Jul 10,
                        2020</small></div>
                  </div>
                  <div class="progress progress-thin">
                    <div class="progress-bar {{$list->status == 'delay' ? 'bg-danger'  : 'bg-success'}}"
                      role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                    </div>
                  </div>
                </td>
                <td>
                  <div class="fw-semibold">{{$list->status}}</div>
                </td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <svg class="icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-options"></use>
                      </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                        href="{{route('project.task.show',['id'=>$list->id])}}">Info</a><a class="dropdown-item"
                        href="#">Edit</a><a class="dropdown-item text-danger" href="#">Delete</a>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="post" action="{{ route('import.project') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Import data project</h5>
                  <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group">
                        <input type="file" class="form-control" name="import_file" id="inputGroupFile04"
                          aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <a href="{{route('format.import.project')}}" class="btn btn-primary">Download Format</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Import</button>
                </div>
              </form>
            </div>
          </div>
        </div>


      </div>
      <div class="d-flex justify-content-center">
        {{ $list_projects->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
  <!-- /.col-->
</div>
<!-- /.row-->

@endsection