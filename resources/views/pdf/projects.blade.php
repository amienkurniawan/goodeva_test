<div class="table-responsive">
  <table class="table border mb-0">
    <thead class="table-light fw-semibold">
      <tr class="align-left">
        <th class="text-start">#</th>
        <th class="text-start">Projects</th>
        <th class="text-start">Date Start</th>
        <th class="text-start">Date End</th>
        <th class="text-start">Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list_projects as $key => $list)
      <tr class="align-left">
        <td>
          <div>{{$key+1}}</div>
        </td>
        <td>
          <div>{{$list->project_name}}</div>
        </td>
        <td>
          {{$list->start_project}}
        </td>
        <td>
          {{$list->end_project}}
        </td>
        <td>
          {{$list->status}}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>