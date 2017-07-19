@extends('layouts.dash_app',['title'=>'databank'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><h1>Old Databank</h1></div>
                    <div class="col-xs-6 col-md-6 center-blocks">
                        <form action="/databank" method="POST" name="search-form" id="search-form">
                            {{csrf_field()}}
                            <h5><label for="search">Search:</label></h5>
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                @foreach($cols as $col)
                                    @if($col!='State' && $col!='created_at' && $col!='updated_at'))
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
                    @php $required=['Ref_No','Date','Candidates_Name','Contact_No','DOB','PP_NO','Trade','Company']; @endphp
                    <div class="">
                        <table class="table table-striped table-bordered editableTable" id="myTable" >
                            <thead>
                            <tr>
                                <th><a title="Add New" class="btn btn-default" data-toggle="modal" data-target="#modal_add">Add New</a></th>
                                @foreach($cols as $col)
                                    @if($col!='created_at' && $col!='updated_at' && $col!='State')
                                        <th>{{$col}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            </thead>

                            <tbody>
                            @php if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin') $read=""; else $read="readonly"; @endphp
                            <tr>
                                <td align="center"><a class="btn btn-link" id="quick_add"><strong><i class="fa fa-plus-square"></i></strong></a></td>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @foreach ($cols as $col)
                                    @if($col!='State' && $col!="created_at" && $col!="updated_at")
                                        <td><input id="qa_{{$col}}" name="{{$col}}" placeholder="{{$col}} @if(in_array($col,$required))*@endif" {{$read}} required/></td>
                                    @endif
                                @endforeach
                            </tr>
                            @php $i=0; $datas_array=array(); @endphp
                            @foreach ($datas as $data)
                                <tr
                                @if($data->State=='vp')
                                    style='background-color: lightgreen;'
                                @elseif($data->State== 'vc')
                                    style='background-color: lightcoral;'
                                @elseif($data->State== 'vf')
                                    style='background-color: lightblue;'
                                @endif
                                >

                                    <th style="min-width: 100px; text-align: center">
                                        <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">

                                            <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$data->Ref_No}}"
                                               title="view"><i class="fa fa-eye"></i></a>
                                            @if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin')
                                                @if($data->State!='vp' && $data->State!='vf')
                                                <a title="visa processing" class="visa btn btn-link" name="{{$data->Ref_No}}_visa"><i
                                                            class="fa fa-cc-visa"></i></a>
                                                @endif
                                            <a title="delete" class="delete btn btn-link" name="{{$data->Ref_No}}_delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </th>
                                    @foreach ($cols as $col)
                                        @if($col!='created_at' && $col!='updated_at' && $col!='State')
                                            @php $datas_array[$i][$col]=$data->$col; @endphp
                                            <td> {{$data->$col}} </td>
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
        </div>
        <br>
        <div class="export">
            <a target="_blank" class="btn btn-primary" href="/export" onclick="event.preventDefault(); document.getElementById('excel-form').submit();">
                Export to Excel
            </a>

            <form id="excel-form" action="/export" method="POST" style="display: none;">
                {{ csrf_field() }}
                <input type="text" name="file" id="file" value="Databank" />
                <input type="text" name="colsString" id="colsString" value="{{serialize($cols)}}" />
                <input type="text" name="discardString" id="discardString" value="{{serialize(['created_at','updated_at','State'])}}" />
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
        <div class="modal fade" id="modal_{{$data->Ref_No}}" role="dialog">
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
                            @if($col!='created_at' && $col!='updated_at' && $col!='State')
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="{{$data->Ref_No. '_' . $j}}">{{$col}}:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
                                                class="form-control"
                                                id="{{$data->Ref_No. '_' . $j}}"
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
                            @if($col!="State" && $col!="created_at" && $col!="updated_at")
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="{{ $col }}_0">{{ $col }}@if(in_array($col,$required)) <span style="color:Red"> *</span>@endif:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8">
                                        <input
                                                type="text"
                                                class="form-control"
                                                id="{{ $col }}_0"
                                                name="{{ $col }}"
                                                placeholder="Enter {{ $col }} here!"
                                        @if(in_array($col,$required)) {{" required"}} @endif
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


    <script type="text/javascript">
    @if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin')
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#quick_add").click(function(){
            var colArray ={!! json_encode($cols) !!};
            var data_string='{{$db_table}},';
            for(var i=0;i<colArray.length;i++)
            {
                if(colArray[i]!=='State' && colArray[i]!=='created_at' && colArray[i]!=='updated_at')
                {
                    var temp=colArray[i];
                    data_string+=colArray[i]+":"+document.getElementById('qa_'+colArray[i]).value+",";
                }
            }
            data_string=data_string+"State:none";


            $.ajax({
                method: 'post',
                url: '/quick_add',
                data: {value:data_string},
                cache: false,
                timeout: 10000,
                success: function (response){
                    if (response) {
                        alert(response);
                    }
                    // Load output into a P
                    else {
                        location.reload(true);
                    }
                }
            });
            return false;
        });

        $(function (){
            $(".delete").click(function(){
                var name=$(this).attr("name");
                var id=parseInt(name.substr(0,name.lastIndexOf('_')));
                var col='Ref_No';


                $.ajax({
                    url: '/delete',
                    type: 'post',
                    data: {
                        db_table:'{{$db_table}}',
                        w_id: id,
                        w_col: col
                    },
                    cache: false,
                    timeout: 10000,
                    success: function (data){
                        if (data) {
                            alert(data);
                        }
// Load output into a P
                        else {
                            location.reload(true);
//                        $('#notice').text('Deleted');
//                        $('#notice').fadeOut().fadeIn();

                        }
                    }
                });

            });
        });

        $(function (){
            $(".visa").click(function(){
                var name=$(this).attr("name");
                var id=parseInt(name.substr(0,name.lastIndexOf('_')));
                var col='Ref_No';

                $.ajax({
                    url: '/visaprocess',
                    type: 'post',
                    data: {
                        db_table1:'databanks',
                        db_table2:'visaprocesses',
                        w_id: id,
                        w_col: col
                    },
                    cache: false,
                    timeout: 10000,
                    success: function (data){
                        if (data) {
                            alert(data);
                        }
// Load output into a P
                        else {
                            location.reload(true);
//                        $('#notice').text('Deleted');
//                        $('#notice').fadeOut().fadeIn();

                        }
                    }
                });

            });
        });

        $(function () {
            $("td").dblclick(function () {
                var OriginalContent = $(this).text();
                OriginalContent=OriginalContent.trim();

                $(this).addClass("cellEditing");
                var myCol = $(this).index()-1;
                var $tr = $(this).closest('tr');
                var myRow = $tr.index()+1;


                var colArray = {!! json_encode($cols) !!} ;

                var id=document.getElementById("myTable").rows[myRow].cells[1].innerHTML;


                $(this).html(
                    "<input placeholder='"+OriginalContent+"' id='"+colArray[myCol]+'_'+myRow+"' name='"+colArray[myCol]+'_'+myRow+"' value='" + OriginalContent + "'/>"+
                    "<input type='hidden' id='where_"+myRow+"_"+myCol+"' name='Ref_No' value='"+id+"' />"
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

            $.ajax({
                url: action,
                type: method,
                data: {
                    db_table:'databanks',
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
@endsection

