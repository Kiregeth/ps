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
        .export{
             padding-top:20px;
             padding-bottom:20px;
         }

    </style>
    @php
        $discard=['photo','app_status','created_at','updated_at','date','db_status'];
        $date=['date_of_birth','date_of_issue','date_of_expiry'];
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
                <form id='ajax-form' method='post' action='/quick_edit_new'>
                    {{ csrf_field() }}
                    <table class="table table-striped table-bordered editableTable" id="myTable">
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
                        @php $i=0; $datas_array=array(); @endphp
                        @foreach ($datas as $data)
                            <tr @if($data->app_status==='db')
                                style="background-color: #BED661;color:white;"
                                @elseif($data->app_status=='vp')
                                style='background-color: lightgreen;'
                                @elseif($data->app_status== 'vc')
                                style='background-color: lightcoral;'
                                @elseif($data->app_status== 'vf')
                                style='background-color: lightblue;'
                                    @endif>
                                <th style="min-width: 100px; text-align: center">
                                    <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                        <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$data->ref_no}}"
                                           title="view"><i class="fa fa-eye"></i></a>
                                        @if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin')
                                            @if($data->app_status!=='db' && $data->app_status!=='vc' && $data->app_status!=='vp' && $data->app_status!=='vf')
                                                <a class="btn btn-link" data-toggle="modal" data-target="#db_{{$data->ref_no}}"
                                                   title="add to databank"><i class="fa fa-database"></i></a>
                                            @endif
                                        @endif
                                    </div>
                                </th>
                                @foreach ($cols as $col)
                                    @if(!in_array($col,$discard))
                                        @php $datas_array[$i][$col]=$data->$col; @endphp
                                        <td> {{$data->$col}} </td>
                                    @endif
                                @endforeach
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
            <br/>
        </div>
        <div class="export">
                <a target="_blank" class="btn btn-primary" href="/export" onclick="event.preventDefault(); document.getElementById('excel-form').submit();">
                    Export to Excel
                </a>

                <form id="excel-form" action="/export" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    <input type="text" name="file" id="file" value="App Form" />
                    <input type="text" name="colsString" id="colsString" value="{{serialize($cols)}}" />
                    <input type="text" name="discardString" id="discardString" value="{{serialize($discard)}}" />
                    <input type="text" name="datasString" id="datasString" value="{{serialize($datas_array)}}" />
                </form>
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

        <script>
            @if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(function () {
                $("td").dblclick(function () {
                    var OriginalContent = $(this).text();
                    OriginalContent = OriginalContent.trim();

                    $(this).addClass("cellEditing");
                    var myCol = $(this).index() - 1;
                    var $tr = $(this).closest('tr');
                    var myRow = $tr.index() + 1;


                    var colArray = {!! json_encode($cols) !!} ;
                    var dateArray= {!! json_encode($date) !!};

                    var id = document.getElementById("myTable").rows[myRow].cells[1].innerHTML;
                    var type;
                    var x;
                    var count=0;
                    for(x in dateArray)
                    {
                        if(colArray[myCol]===dateArray[x])
                        {
                            count++;
                            break;
                        }
                    }
                    if(count>0) type='date'; else type='text';
                    if(colArray[myCol]==='email') type='email';

                    if(colArray[myCol]!=='ref_no' && colArray[myCol]!=='date')
                    {
                        $(this).html(
                            "<input type='"+type+"' placeholder='"+OriginalContent+"' id='"+colArray[myCol]+'_'+myRow+"' name='"+colArray[myCol]+'_'+myRow+"' value='" + OriginalContent + "'/>"+
                            "<input type='hidden' id='where_"+myRow+"_"+myCol+"' name='ref_no' value='"+id+"' />"
                        );

                        $(this).children().first().focus();

                        $(this).children().first().keypress(function (e) {
                            if (e.which == 13) {
                                var res=autosubmit(colArray,myCol,myRow);
                                var val=document.getElementById(colArray[myCol]+'_'+myRow).value;
                                $(this).parent().text(val);
                                $(this).parent().removeClass("cellEditing");
                            }
                        });

                        $(this).children().first().blur(function(){

                            var res=autosubmit(colArray,myCol,myRow);
                            var val=document.getElementById(colArray[myCol]+'_'+myRow).value;
                            $(this).parent().text(val);
                            $(this).parent().removeClass("cellEditing");
                        });
                    }
                });
            });

            function autosubmit(colArray,myCol,myRow)
            {

                var input=document.getElementById(colArray[myCol]+'_'+myRow);

                var column = input.name;
                column=column.substr(0, column.lastIndexOf('_'));
                var value = input.value;
                var form = document.getElementById('ajax-form');
                var method = form.method;
                var action = form.action;



                var where=document.getElementById('where_'+myRow+'_'+myCol);
                var where_val = where.value;
                var where_col = where.name;

//                alert(action+': '+method+'        '+column+': '+value+'   '+where_col+' '+where_val);
                $.ajax({
                    url: action,
                    type: method,
                    data: {
                        val: value,
                        col: column,
                        w_col: where_col,
                        w_val: where_val
                    },
                    cache: false,
                    timeout: 10000,
                    success: function (data){
                        if (data) {
                            alert(data);
                        }
                        // Load output into a P
                        else {


                        }
                    }
                });
                // Prevent normal submission of form
                return false;
            }
            @endif
        </script>
    @endforeach
@endsection