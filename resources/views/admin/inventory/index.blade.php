@extends('layouts.admin-layout')

@section('title') Inventory Group List @endsection

@section('extraCSS')
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('extraJS')
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(function() {
        $("#inventoryGroup").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#inventoryGroup_wrapper .col-md-6:eq(0)');
    });

    @if(Session::has('success'))
    toastr.success("{{session('success')}}")
    @endif

    @if(Session::has('error'))
    toastr.error("{{session('error')}}")
    @endif
</script>
@endsection


@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h3 class="card-title">DataTable with default features</h3> -->

                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-new-group">
                            New Group
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="inventoryGroup" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Group</th>
                                    <th>Variety Count</th>
                                    <th>Properties</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1 @endphp
                                @foreach ($inventorygroups as $inventorygroup )
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td><a href="{{ route ('inventoryGroup.show', $inventorygroup->id )}}">{{$inventorygroup->title}}</a></td>
                                    <td>{{$inventorygroup->inventories->count()}}</td>
                                    <td>{{$inventorygroup->properties}}</td>
                                    <td class="d-flex justify-space-around">
                                        <button type="button" class="btn btn-info float-right mr-3" data-toggle="modal" data-target="#modal-edit-group{{$inventorygroup->id}}">
                                            Edit
                                        </button>
                                        <a href="{{ route('inventoryGroup.destroy', $inventorygroup->id)}}" class="btn btn-danger float-right">
                                            Delete
                                        </a>
                                        <!-- Modals -->
                                        <div class="modal fade" id="modal-edit-group{{$inventorygroup->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Add Items</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    {!! Form::open(['route' => ['inventoryGroup.update', $inventorygroup->id], 'method' => 'PUT']) !!}
                                                    <div class="modal-body">
                                                        <!-- general form elements -->
                                                        <div class="card card-primary">
                                                            <!-- form start -->

                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="title">Inventory Group</label>
                                                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Inventory Group Name" Required value="{{$inventorygroup->title}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="properties">Properties</label>
                                                                    <input type="text" class="form-control" id="properties" name="properties" placeholder="eg. thickness,size,color" Required value="{{$inventorygroup->properties}}">
                                                                </div>

                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                        <!-- /.card -->
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                                        {!! Form::submit('Update Inventory Group', ['class' => 'btn btn-primary']) !!}
                                                    </div>
                                                    {!! Form::close() !!}
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
        <!-- /.row -->

    </div><!--/. container-fluid -->

    <!-- Modals -->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Items</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- form start -->

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



    <!-- Modals -->
    <div class="modal fade" id="modal-new-group">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Items</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('inventoryGroup.store')}}">
                    @csrf
                    <div class="modal-body">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- form start -->

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Inventory Group</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Inventory Group Name" Required>
                                </div>
                                <div class="form-group">
                                    <label for="properties">Properties</label>
                                    <P class="text-danger">Please put space after the comma!!</P>
                                    <input type="text" class="form-control" id="properties" name="properties" placeholder="eg. thickness, size, color" Required>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</section>
<!-- /.content -->
@endsection
