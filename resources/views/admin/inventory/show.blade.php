@extends('layouts.admin-layout')

@section('title') {{$inventorygroup->title}} List @endsection

@section('extraCSS')
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
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

<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(function() {
        $("#inventoryGroup").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#inventoryGroup_wrapper .col-md-6:eq(0)');
    });

    @if(Session::has('success'))
    toastr.success("{{session('success')}}")
    @endif

    @if(Session::has('error'))
    toastr.error("{{session('error')}}")
    @endif

    //Initialize Select2 Elements
    $('.select2').select2()

    // $(document).on("click", ".btn-block", function() {
    //     var itemid = $(this).attr('data-item');
    //     $("#lineitem").attr("href", "/orders/line-item-delete/" + itemid)
    // });
</script>
@endsection





@section('extraScript')





@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <!-- Info boxes
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-6 col-md-3 ">
                <button type="button" class="btn" data-toggle="modal" data-target="#modal-add-item">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Add Items</span>
                        </div>
                        /.info-box-content
                    </div>
                    /.info-box
                </button>
            </div>
            /.col
            <div class="col-12 col-sm-6 col-md-3 ">
                <button type="button" class="btn" data-toggle="modal" data-target="#modal-take-item">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Take Items</span>
                        </div>
                        /.info-box-content
                    </div>
                    /.info-box
                </button>
            </div>
            /.col

        </div>
        /.row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        <!-- <h3 class="card-title">DataTable with default features</h3> -->

                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-new-item">
                            Register New Item
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="inventoryGroup" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Label</th>
                                    <th>Quantity</th>
                                    @php
                                    $inventoryGroupProperties = explode (', ', $inventorygroup->properties)

                                    @endphp
                                    @foreach ($inventoryGroupProperties as $property )
                                    <th>{{$property}}</th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1 @endphp
                                @foreach ($inventoryitems as $inventoryitem)

                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$inventoryitem->label}}</td>
                                    <td>{{$inventoryitem->quantity}}</td>
                                    @php
                                    $inventoryItemProperties = explode (', ', $inventoryitem->itemProperties[0]->properties);
                                    @endphp

                                    @foreach ($inventoryItemProperties as $eachproperty)
                                    <td>
                                        {{$eachproperty}}
                                    </td>

                                    @endforeach
                                    <td>
                                        <button class="btn-sm btn-success" data-toggle="modal" data-target="#modal-add-one-item{{$inventoryitem->id}}">Add</button>

                                        <button class="btn-sm btn-warning" data-toggle="modal" data-target="#modal-take{{$inventoryitem->id}}">Take</button>
                                        <a class="btn-sm btn-danger" href="#">Delete</a>


                                    </td>
                                </tr>
                                <div class="AddItemModal">
                                    <!-- Modals -->
                                    <div class="modal hide fade" id="modal-add-one-item{{$inventoryitem->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">New Stock? </h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="{{route('inventory.stock.add')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <!-- general form elements -->
                                                        <div class="card card-primary">
                                                            <!-- form start -->

                                                            <div class="card-body">

                                                                <input type="hidden" name="group_id" value="" Required>

                                                                <div class="form-group">
                                                                    <label>Item</label>
                                                                    <h5>
                                                                        {{$inventoryitem->group->title}}-{{$inventoryitem->label}}-{{$inventoryitem->itemProperties[0]->properties}}
                                                                    </h5>
                                                                    <input type="hidden" name="item_name" value="{{$inventoryitem->group->title}}-{{$inventoryitem->label}}-{{$inventoryitem->itemProperties[0]->properties}}">
                                                                    <input type="hidden" name="group_id" value="{{$inventorygroup->id}}">
                                                                    <input type="hidden" name="item_id" value="{{$inventoryitem->id}}">

                                                                </div>
                                                                <!-- /.form-group -->
                                                                <div class="form-group">
                                                                    <label for="quantity">Item Quantity</label>
                                                                    <p>How many of this item will you like to add</p>
                                                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter item quantity" Required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="comment">Comment</label>
                                                                    <textarea name="comment" class="form-control" cols="30" rows="3"></textarea>
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
                                </div>

                                <div class="TakeItemModal">
                                    <!-- Modals -->
                                    <div class="modal hide fade" id="modal-take{{$inventoryitem->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Need to take an Item? </h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="{{route('inventory.stock.take')}}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <!-- general form elements -->
                                                        <div class="card card-primary">
                                                            <!-- form start -->

                                                            <div class="card-body">

                                                                <input type="hidden" name="group_id" value="" Required>

                                                                <div class="form-group">
                                                                    <label>Item</label>
                                                                    <h5>
                                                                        {{$inventoryitem->group->title}}-{{$inventoryitem->label}}-{{$inventoryitem->itemProperties[0]->properties}}
                                                                    </h5>
                                                                    <input type="hidden" name="item_name" value="{{$inventoryitem->group->title}}-{{$inventoryitem->label}}-{{$inventoryitem->itemProperties[0]->properties}}">
                                                                    <input type="hidden" name="group_id" value="{{$inventorygroup->id}}">
                                                                    <input type="hidden" name="item_id" value="{{$inventoryitem->id}}">

                                                                </div>
                                                                <!-- /.form-group -->
                                                                <div class="form-group">
                                                                    <label for="quantity">Item Quantity</label>
                                                                    <p>How many of this item will you like to take</p>
                                                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter item quantity" Required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="comment">Comment</label>
                                                                    <textarea name="comment" class="form-control" cols="30" rows="3"></textarea>
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
                                </div>
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
    <div class="modal fade" id="modal-new-item">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Register a New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('inventories.store')}}">
                    @csrf
                    <div class="modal-body">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- form start -->

                            <div class="card-body">
                                <input type="hidden" name="group_id" value="{{$inventorygroup->id}}" Required>
                                <div class="form-group">
                                    <label for="title">Item Label</label>
                                    <input type="text" class="form-control" id="title" name="label" placeholder="Enter Inventory Group Name" Required>
                                </div>
                                @foreach ($inventoryGroupProperties as $property )
                                <div class="form-group">
                                    <label for="properties">{{$property}}</label>
                                    <input type="text" class="form-control" id="properties" name="{{$property}}" placeholder="Enter {{$property}}" Required>
                                </div>
                                @endforeach

                                <div class="form-group">
                                    <label for="quantity">Item Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter item quantity" Required>
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
    <div class="modal fade" id="modal-add-item">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Stock? </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('inventory.stock.add')}}">
                    @csrf
                    <p class="text-center">Select an item that has been restocked, always add a comment</p>
                    <div class="modal-body">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <!-- form start -->

                            <div class="card-body">
                                <input type="hidden" name="group_id" value="{{$inventorygroup->id}}" Required>

                                <div class="form-group">
                                    <label>Select Item</label>

                                    <select name="title" class="form-control select2" style="width: 100%;">
                                        <option selected="selected" disabled>Select an Item</option>
                                        @foreach ($inventoryitems as $inventoryitem)

                                        <option value="{{$inventoryitem->group->title}}-{{$inventoryitem->label}}-{{$inventoryitem->itemProperties[0]->properties}}">
                                            {{$inventoryitem->group->title}}-{{$inventoryitem->label}}-{{$inventoryitem->itemProperties[0]->properties}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- /.form-group -->



                                <div class="form-group">
                                    <label for="quantity">Item Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter item quantity" Required>
                                </div>

                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea name="comment" class="form-control" cols="30" rows="3"></textarea>
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
