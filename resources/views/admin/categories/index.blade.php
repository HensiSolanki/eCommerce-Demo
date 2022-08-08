@extends('admin.layouts.app')
@section('title', $module_name)
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>{{ $module_name }}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/admin') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a>{{ $module_name }} List</a>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    @if(isset($module_name))
                    <h5 class="card-title mb-0">{{ $module_name }} List</h5>
                    @endif
                    <div class="ibox-tools">
                        @can('user_add')
                        <a class="btn btn-primary btn-xs" href="{{ $module_route.'/create' }}" title="Add"><i
                                class="fa fa-plus"></i> Add</a>
                        @endcan
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="users-datatable" class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ategory Name</th>
                                    <th>Slug</th>
                                    <th>Categories Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
<script>
    $(document).ready(function(){

        var oTable = $('#users-datatable').DataTable({
            processing: true,
            serverSide: true,
			responsive: true,
			searching: true,
			ordering: true,
            pagingType: "full_numbers",
			ajax: {
				url: "{!! $module_route.'/datatable' !!}",
				data:function(data) {
				}
			},
            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable:false, width: 20 },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'category_slug',
                    name: 'category_slug'
                },
                {
                data: 'image_thumb_url',
                name: 'image',
                'bSortable': false,
                'aTargets': [-1],
                'render': function(data, type, row) {
                    return `<img src="${data}" width="100" height="100"/>`;
                }
            },
                {
                    data:  null,
                    orderable: false,
                    searchable: false,
                    responsivePriority: 1,
                    targets: 0,
                    className:"text-center",
                    visible: "{{ ($authUser->can('user_edit') || $authUser->can('user_delete')) }}",
                    render:function(o){
						var element =  '<div class="btn-group">';
						element +=  '@can("user_edit")<a class="btn btn-warning btn-xs" title="Edit" href="{{ $module_route }}/' + o.id + '/edit" ><i class="fa fa-edit"></i></a>@endcan';
						element +=  '@can("user_delete")<button class="btn btn-danger btn-xs" title="Delete" onclick="deleteUser(' + o.id + ')"><i class="fa fa-trash"></i></button>@endcan';
						element +=  '</div>';
						return element;
                    }
                }
            ]
        });

        deleteUser = (userId) => {
            let url = '{{ $module_route }}/'+userId;
            deleteRecordByAjax(url, "{{$module_name}}", oTable);
        }

	});
</script>
@endpush
