@extends('layouts.dash_app',['title'=>'users'])

@section('content')
    <style>
        * {
            font-family:Consolas;
        }
        .modal-dialog {
            width: 80% !important;
        }
        .modal-content input[type=text], .modal-content input[type=number] {
            max-height: 24px;
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
        th .center-block a{
            padding:0 !important;
            margin:0 !important;
        }
        .fa{
            color: #000;
        }
        th,td{
            padding:0 !important;
            padding-left:5px !important;
            padding-right:5px !important;
            min-width: 50px !important;
            max-width:200px !important;
        }
        thead th{
            padding:10px !important;
            max-width:200px !important;
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
    @php $discard=['created_at','updated_at','password','remember_token'] @endphp
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><h1>Users</h1></div>
                    <div class="col-xs-6 col-md-6 center-blocks">
                        <form action="/users" method="POST" name="search-form" id="search-form">
                            {{csrf_field()}}
                            <h5><label for="search">Search:</label></h5>
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                @foreach($cols as $col)
                                    @if(!in_array($col,$discard)))
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
                <form id='ajax-form' method='post' action='/quick_edit'>
                    {{ csrf_field() }}
                    <div class="">
                        <table class="table table-striped table-bordered editableTable" id="myTable" >
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                @foreach($cols as $col)
                                    @if(!in_array($col,$discard))
                                        <th>{{strtoupper($col)}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            </thead>

                            <tbody>

                            @foreach ($users as $user)
                                <tr>
                                    <th style="text-align: center">
                                        <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">

                                            <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$user->id}}"
                                               title="view"><i class="fa fa-eye"></i></a>

                                        </div>
                                    </th>
                                    @foreach ($cols as $col)
                                        @if(!in_array($col,$discard))
                                            <td> {{$user->$col}} </td>
                                        @endif
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

    @foreach($users as $user)
        <div class="modal fade" id="modal_{{$user->id}}" role="dialog">
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
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="{{$user->id. '_' . $j}}">{{$col}}:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
                                                class="form-control"
                                                id="{{$user->id. '_' . $j}}"
                                                value="{{$user->$col}}" readonly/>
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