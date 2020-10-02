@extends('layouts.admin')
@section('content')
@can('moving_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.movings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.moving.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.moving.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Moving">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.moving.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.moving.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.moving.fields.moving_from') }}
                        </th>
                        <th>
                            {{ trans('cruds.moving.fields.moving_to') }}
                        </th>
                        <th>
                            {{ trans('cruds.moving.fields.moving_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.moving.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.moving.fields.paid_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movings as $key => $moving)
                        <tr data-entry-id="{{ $moving->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $moving->id ?? '' }}
                            </td>
                            <td>
                                {{ $moving->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $moving->moving_from ?? '' }}
                            </td>
                            <td>
                                {{ $moving->moving_to ?? '' }}
                            </td>
                            <td>
                                {{ $moving->moving_date ?? '' }}
                            </td>
                            <td>
                                {{ $moving->price ?? '' }}
                            </td>
                            <td>
                                {{ $moving->paid_at ?? '' }}
                            </td>
                            <td>
                                @can('moving_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.movings.show', $moving->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('moving_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.movings.edit', $moving->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('moving_delete')
                                    <form action="{{ route('admin.movings.destroy', $moving->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('moving_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.movings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Moving:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection