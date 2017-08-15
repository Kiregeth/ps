@extends('layouts.dash_app',['title'=>'visitor_log'])

@section('content')
    @php
        $date=['time'];
        $fields=['sn','visitor_name','contact_no','type','pp_no','visit_purpose','remarks','time'];
        $required=['visitor_name','contact_no','type','visit_purpose'];

    @endphp
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><h1>Visitor Log</h1></div>
                    <div class="col-xs-6 col-md-6 center-blocks">
                        <form action="/reception" method="POST" name="search-form" id="search-form">
                            {{csrf_field()}}
                            <h5><label for="search">Search:</label></h5>
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                @foreach($cols as $col)
                                    @if($col!='State' && $col!='created_at' && $col!='updated_at')
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
                    <table class="table table-striped table-bordered editableTable" id="myTable">
                        <thead>
                        <tr>
                            <th><a title="Add New" class="btn btn-default" data-toggle="modal" data-target="#modal_add">Add New</a></th>
                            @foreach($cols as $col)
                                @if($col!='created_at' && $col!='updated_at')
                                <th>{{$col}}</th>
                                @endif
                            @endforeach
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <th></th>
                            <td align="center"><a class="btn btn-link" id="quick_add"><strong><i class="fa fa-plus-square"></i></strong></a></td>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @foreach ($cols as $col)
                                @if($col!='sn' && $col!='time' && $col!="created_at" && $col!="updated_at")
                                    @if($col=='type')
                                        <td>
                                            <select id="qa_{{$col}}" name="{{$col}}">
                                                @foreach($types as $type)
                                                    <option value="{{$type->type}}">{{$type->type}}</option>
                                                @endforeach
                                            </select>

                                        </td>
                                    @else
                                        <td><input id="qa_{{$col}}" name="{{$col}}" placeholder="{{$col}} @if(in_array($col,$required))*@endif" required/></td>
                                    @endif
                                @endif
                            @endforeach
                            <td>&nbsp</td>
                        </tr>
                        @php $i=0; $datas_array=array(); @endphp
                        @foreach ($logs as $log)
                            <tr>
                                <th style="min-width: 100px; text-align: center">
                                    <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                        <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$log->sn}}"
                                           title="view"><i class="fa fa-eye"></i></a>
                                    </div>
                                </th>
                                @foreach ($cols as $col)
                                    @if($col!='created_at' && $col!='updated_at')
                                        @php $datas_array[$i][$col]=$log->$col; @endphp
                                    <td> {{$log->$col}} </td>
                                    @endif
                                @endforeach
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
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
                <input type="text" name="file" id="file" value="Visitor Log" />
                <input type="text" name="colsString" id="colsString" value="{{serialize($cols)}}" />
                <input type="text" name="discardString" id="discardString" value="{{serialize(['created_at','updated_at'])}}" />
                <input type="text" name="datasString" id="datasString" value="{{serialize($datas_array)}}" />
            </form>
        </div>
        @if($sel!="" && $search!="")
            <div class="center-block">{{$logs->appends(['sel' => $sel,'search'=>$search])->render()}}</div>
        @else
            <div class="center-block">{{$logs->render()}}</div>
        @endif
        <br/>
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
                            @if($col!='created_at' && $col!='updated_at')
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
    <div class="modal fade" id="modal_add" role="dialog">
        <div class="modal-dialog" >

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" name="frm_add" action="/add">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add New</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="db_table" value="visitor_logs">
                        @foreach ($cols as $col)
                            @if($col!="sn" && $col!="time" && $col!="created_at" && $col!="updated_at")
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="{{ $col }}_0">{{ $col }} @if(in_array($col,$required))*@endif:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        @if($col=='type')
                                        <select id="qa_{{$col}}" name="{{$col}}" class="form-control">
                                            @foreach($types as $type)
                                                <option value="{{$type->type}}">{{$type->type}}</option>
                                            @endforeach
                                        </select>
                                        @else
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="{{ $col }}_0"
                                                name="{{ $col }}"
                                                placeholder="Enter {{ $col }} here!"
                                        @if(in_array($col,$required)) {{" required"}} @endif
                                        />
                                        @endif
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

    <script type="text/javascript">
        @if(in_array('operation-view',session('permission')) )
        $("#quick_add").click(function(){
            var colArray ={!! json_encode($cols) !!};
            var data_string='{{$db_table}},';
            for(var i=0;i<colArray.length;i++)
            {
                if(colArray[i]!=='sn' && colArray[i]!=='time' && colArray[i]!=='created_at' && colArray[i]!=='updated_at')
                {
                    var temp=colArray[i];
                    data_string+=colArray[i]+":"+document.getElementById('qa_'+colArray[i]).value+",";
                }
            }
            data_string=data_string.substr(0,data_string.length-1);
            $.post('/quick_add', {'value':data_string,'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
            return false;
        });
        @endif

        {{--@if(in_array('operation-edit',session('permission')) )--}}
        {{--$(function () {--}}
            {{--$("td").dblclick(function () {--}}
                {{--var OriginalContent = $(this).text();--}}
                {{--OriginalContent = OriginalContent.trim();--}}

                {{--$(this).addClass("cellEditing");--}}
                {{--var myCol = $(this).index() - 2;--}}
                {{--var $tr = $(this).closest('tr');--}}
                {{--var myRow = $tr.index() + 1;--}}


                {{--var colArray = {!! json_encode($fields) !!} ;--}}
                {{--var dateArray= {!! json_encode($date) !!};--}}

                {{--var id = document.getElementById("myTable").rows[myRow].cells[1].innerHTML;--}}
{{--//                alert(id);--}}
                {{--var type;--}}
                {{--if(colArray[myCol]!=='time') {--}}
                    {{--type = 'datetime-local';--}}
                {{--} else {--}}
                    {{--type = 'text';--}}
                {{--}--}}

                {{--if(colArray[myCol]!='sn' && colArray[myCol]!='time')--}}
                {{--{--}}
                    {{--$(this).html(--}}
                        {{--"<input type='text' placeholder='"+OriginalContent+"' id='"+colArray[myCol]+'_'+myRow+"' name='"+colArray[myCol]+'_'+myRow+"' value='" + OriginalContent + "'/>"+--}}
                        {{--"<input type='hidden' id='where_"+myRow+"_"+myCol+"' name='ref_no' value='"+id+"' />"--}}
                    {{--);--}}

                    {{--$(this).children().first().focus();--}}
                    {{--$(this).children().first().keypress(function (e) {--}}
                        {{--if (e.which == 13) {--}}
{{--//                            var res=autosubmit(colArray,myCol,myRow);--}}
                            {{--var val=document.getElementById(colArray[myCol]+'_'+myRow).value;--}}
                            {{--$(this).parent().text(val);--}}
                            {{--$(this).parent().removeClass("cellEditing");--}}
                        {{--}--}}
                    {{--});--}}
                    {{--$(this).children().first().blur(function(){--}}
{{--//                        var res=autosubmit(colArray,myCol,myRow);--}}
                        {{--var val=document.getElementById(colArray[myCol]+'_'+myRow).value;--}}
                        {{--$(this).parent().text(val);--}}
                        {{--$(this).parent().removeClass("cellEditing");--}}
                    {{--});--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}

        {{--function autosubmit(colArray,myCol,myRow)--}}
        {{--{--}}
            {{--var input=document.getElementById(colArray[myCol]+'_'+myRow);--}}

            {{--var column = input.name;--}}
            {{--column=column.substr(0, column.lastIndexOf('_'));--}}
            {{--var value = input.value;--}}
            {{--var form = document.getElementById('ajax-form');--}}
            {{--var method = form.method;--}}
            {{--var action = form.action;--}}
            {{--var where=document.getElementById('where_'+myRow+'_'+myCol);--}}
            {{--var where_val = where.value;--}}
            {{--var where_col = where.name;--}}
            {{--$.post(action, {'db_table':'{{$db_table}}','val': value,'col': column,'w_col': where_col,'w_val': where_val,'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):null});--}}
            {{--return false;--}}
        {{--}--}}
        {{--@endif--}}
    </script>
@endsection

