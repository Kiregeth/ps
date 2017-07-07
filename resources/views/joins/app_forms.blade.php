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
            max-height: 20px;
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

        a.btn.btn-link{
            padding:0;
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
        .form-control
        {
            max-height: 20px;
        }
    </style>
    @php
        $discard=['photo','app_status','created_at','updated_at','date','db_status'];
        $db_date_field=['offer_letter_received_date','old_vp_date','pp_returned_date','pp_resubmitted_date'];
        $db_required=['trade','company'];
    @endphp
    <div class="container">
        @if(session()->has('message'))
            <h3 align="center" class="alert alert-success">{{session()->get('message')}}</h3>
        @endif
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
                                    @if(!in_array($col,$discard))
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
                                    @if(!in_array($col,$discard))
                                        <th>{{strtoupper(preg_replace('/_+/', ' ', $col))}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($datas as $data)
                                <tr @if($data->app_status==='db')
                                    style="background-color: #BED661;color:white;"
                                    @endif>
                                    <th style="min-width: 100px; text-align: center">
                                        <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                            <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$data->ref_no}}"
                                               title="view"><i class="fa fa-eye"></i></a>
                                            @if($data->app_status!=='db')
                                                <a class="btn btn-link" data-toggle="modal" data-target="#db_{{$data->ref_no}}"
                                                title="add to databank"><i class="fa fa-database"></i></a>
                                            @endif
                                        </div>
                                    </th>
                                    @foreach ($cols as $col)
                                        @if(!in_array($col,$discard))
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
                            @if(!in_array($col,$discard))
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

    @foreach($datas as $data)
        <div class="modal fade" id="db_{{$data->ref_no}}" role="dialog">
            <div class="modal-dialog" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add to Databank</h4>
                    </div>
                    <form action="/add_to_db" method="post" id="data-fom-{{$data->ref_no}}">
                        {{csrf_field()}}
                        <div class="modal-body">
                            @php $j=0;@endphp
                            @foreach($db_cols as $col)
                                @if(!in_array($col,$discard))
                                    <div class="row">
                                        <div class="col-xs-3 col-md-3"><label class="control-label pull-right"
                                                                              for="{{$data->ref_no. '_' . $j}}">{{ucfirst(preg_replace('/_+/', ' ', $col))}}@if(in_array($col,$db_required))*@endif:</label>
                                        </div>
                                        @if(in_array($col,$db_date_field))
                                            <div class="col-xs-7 col-md-7"><input
                                                        type="date"
                                                        class="form-control"
                                                        id="{{$data->ref_no. '_' . $j}}"
                                                        name="{{$col}}"
                                                        placeholder="Enter {{ucfirst(preg_replace('/_+/', ' ', $col))}} here!@if(in_array($col,$db_required))*@endif"
                                                        @if($col==='ref_no')value="{{$data->ref_no}}"  readonly @endif @if(in_array($col,$db_required)) required @endif/>
                                            </div>
                                        @else
                                            <div class="col-xs-7 col-md-7"><input
                                                        class="form-control"
                                                        type="text"
                                                        id="{{$data->ref_no. '_' . $j}}"
                                                        name="{{$col}}"
                                                        placeholder="Enter {{ucfirst(preg_replace('/_+/', ' ', $col))}} here!@if(in_array($col,$db_required))*@endif"
                                                        @if($col==='ref_no')value="{{$data->ref_no}}"  readonly @endif @if(in_array($col,$db_required)) required @endif/>
                                            </div>
                                        @endif
                                    </div>
                                    @php $j++; @endphp
                                @endif
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-default" value="Add"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endforeach
@endsection