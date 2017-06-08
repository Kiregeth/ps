@extends('layouts.dash_app',['title'=>'visitor_log'])

@section('content')
    <style>
    .modal-dialog {
    width: 80% !important;
    }
    .modal-content input[readonly]
    {
    background-color:grey;
    max-height:20px;
    color:white;
    }
    .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    }
    .close:hover,
    .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12" style="width:100% important; overflow-x: scroll !important;">
                <h1>Visitor Log</h1>
                <form id='ajax-form' method='post' action='process/update.php'>
                <div class="">
                    <table class="table table-striped table-bordered editableTable" >
                        <thead>
                        <tr>
                            <th><a title="Add New" class="btn btn-default" data-toggle="modal" data-target="#modal_add">Add New</a></th>
                            @foreach($cols as $col)
                                <th>{{$col}}</th>
                            @endforeach
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <th></th>
                            <td align="center"><a class="btn btn-link" id="quick_add"><strong>+</strong></a></td>

                            @foreach ($cols as $col)
                                @if($col!='sn' && $col!='time')
                                    <td><input id="qa_{{$col}}" name="{{$col}}" placeholder="{{$col}}" required/></td>
                                @endif
                            @endforeach
                            <td>&nbsp</td>
                        </tr>
                        @foreach ($logs as $log)
                            <tr>
                                <th style="min-width: 100px; text-align: center">
                                    <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                        <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$log->sn}}"
                                           title="view"><i class="fa fa-eye"></i></a>
                                    </div>
                                </th>
                                @foreach ($cols as $col)
                                    <td> {{$log->$col}} </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($logs as $log)
        <div class="modal fade" id="modal_{{$log->sn}}" role="dialog">
            <div class="modal-dialog" >

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Data View</h4>
                    </div>
                    <div class="modal-body">
                        @php $j=0;@endphp
                        @foreach($cols as $col)
                            <div class="row">
                                <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                      for="{{$log->sn. '_' . $j}}">{{$col}}:</label>
                                </div>
                                <div class="col-xs-8 col-md-8"><input
                                            class="form-control"
                                            id="{{$log->sn. '_' . $j}}"
                                            value="{{$log->$col}}" readonly/>
                                </div>
                            </div>
                            @php $j++; @endphp
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
    <div class="modal fade" id="modal_add" role="dialog">
        <div class="modal-dialog" >

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" name="frm_add" action="process/add.php">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add New</h4>
                    </div>
                    <div class="modal-body">
                        @foreach ($cols as $col)
                            @if($col!="sn" && $col!="time")
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="{{ $col }}_0">{{ $col }}:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="{{ $col }}_0"
                                                name="{{ $col }}"
                                                placeholder="Enter {{ $col }} here!"
                                        @if($col!="remarks") {{" required"}} @endif
                                        />
                                    </div>
                                </div>
                            @endif
                        @endforeach


                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="db_table" value="{{$db_table}}" />
                        <input type="submit" value="Add" name="add" class="btn btn-default" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

