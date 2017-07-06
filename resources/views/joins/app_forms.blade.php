@extends('layouts.dash_app',['title'=>'app_forms'])

@section('content')
    <style>
        * {
            font-family:Consolas;
        }
        .modal-dialog {
            width: 80% !important;
        }
        .modal-content input[type=text], .modal-content input[type=number], .modal-content select {
            max-height: 24px;
            padding: 0 0 0 10px;
            margin:2px;
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
        .fa{
            color:#000;
        }
        th,td{
            padding:0 !important;
            padding-left:5px !important;
            padding-right:5px !important;
            min-width: 70px;
        }

        .caret{
            display:none;
        }
        .select
        {
            color:blue !important;
        }

        .btn-info
        {
            padding:5px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><h1>Application Forms</h1></div>
                    <div class="col-xs-6 col-md-6 center-blocks">
                        <form action="/app_forms" method="POST" name="search-form" id="search-form">
                            {{csrf_field()}}
                            <h5><label for="search">Search:</label></h5>
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                @foreach($cols as $col)
                                    @if($col!='photo' && $col!='created_at' && $col!='updated_at')
                                        <option value="{{$col}}" @if($sel===$col){{'selected'}}@endif>{{$col}}</option>
                                    @endif
                                @endforeach
                            </select>

                            <input name="search" id="search" type="text" value="{{$search}}" placeholder="Search"/>

                            <input type="submit" style="display:none" />

                        </form>
                    </div>
                </div>
                <br/>
                <form id='ajax-form' method='post' action='/'>
                    {{ csrf_field() }}
                    <div class="">
                        <table class="table table-striped table-bordered editableTable" >
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                @foreach($cols as $col)
                                    @if($col!='photo' &&$col!='created_at' && $col!='updated_at')
                                        <th>{{strtoupper(preg_replace('/_+/', ' ', $col))}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <th style="min-width: 100px; text-align: center">
                                        <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                            <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$data->ref_no}}"
                                               title="view"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </th>
                                    @foreach ($cols as $col)
                                        @if($col!='photo' &&$col!='created_at' && $col!='updated_at')
                                            <td> {{$data->$col}} </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <br/>
        </div>
        @if($sel!="" && $search!="")
            <div class="center-block">{{$datas->appends(['sel' => $sel,'search'=>$search])->render()}}</div>
        @else
            <div class="center-block">{{$datas->render()}}</div>
        @endif
        <br/>
    </div>

    @foreach($datas as $data)
        <div class="modal fade" id="modal_{{$data->ref_no}}" role="dialog">
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
                            @if($col!='photo' && $col!='created_at' && $col!='updated_at')
                                <div class="row">
                                    <div class="col-xs-3 col-md-3"><label class="control-label pull-right"
                                                                          for="{{$data->ref_no. '_' . $j}}">{{ucfirst(preg_replace('/_+/', ' ', $col))}}:</label>
                                    </div>
                                    <div class="col-xs-7 col-md-7"><input
                                                class="form-control"
                                                id="{{$data->ref_no. '_' . $j}}"
                                                value="{{$data->$col}}" readonly/>
                                    </div>
                                </div>
                                @php $j++; @endphp
                            @endif
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
@endsection