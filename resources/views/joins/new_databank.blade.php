@extends('layouts.dash_app',['title'=>'new_databank'])

@section('content')
    @php
            $fields=['ref_no','date','name','mobile_no','contact_address','email','date_of_birth', 'passport_no',
                   'pp_status','local_agent','la_contact','trade','company','offer_letter_received_date','old_vp_date',
                   'pp_returned_date','pp_resubmitted_date','remarks','db_status'];
            $discard=['photo','db_status','created_at','updated_at','app_status'];
            $date=['date','date_of_birth','offer_letter_received_date','old_vp_date','pp_returned_date','pp_resubmitted_date'];

    @endphp
        <div class="container">
            @if(session()->has('message'))
                <h3 align="center" class="alert alert-success">{{session()->get('message')}}</h3>
            @endif
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-xs-6 col-md-6"><h1>Databank</h1></div>
                        <div class="col-xs-6 col-md-6 center-blocks">
                            <form action="/new_databank" method="POST" name="search-form" id="search-form">
                                {{csrf_field()}}
                                <h5><label for="search">Search:</label></h5>
                                @php if(strpos($sel, '.') !== false) $sel=substr($sel, strpos($sel, ".") + 1) @endphp
                                <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                    @foreach($fields as $col)
                                        @if(!in_array($col,$discard))
                                            <option value="{{$col}}" @if($sel===$col){{'selected'}}@endif>{{ucwords($col)}}</option>
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
                                @foreach($fields as $col)
                                    @if(!in_array($col,$discard))
                                        <th>{{strtoupper(preg_replace('/_+/', ' ', $col))}}</th>
                                    @endif
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @php $i=0; $datas_array=array(); @endphp
                            @foreach ($datas as $data)
                                <tr
                                        @if($data->db_status=='vp')
                                        style='background-color: lightgreen;'
                                        @elseif($data->db_status== 'vc')
                                        style='background-color: lightcoral;'
                                        @elseif($data->db_status== 'vf')
                                        style='background-color: lightblue;'
                                        @endif
                                >

                                    <th style="min-width: 100px; text-align: center">
                                        <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">

                                            <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$data->ref_no}}"
                                               title="view"><i class="fa fa-eye"></i></a>
                                            @if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin')
                                                @if($data->db_status!='vp' && $data->db_status!='vf')
                                                    <a class="btn btn-link" data-toggle="modal" data-target="#visa_{{$data->ref_no}}"
                                                       title="add to visa processing"><i class="fa fa-cc-visa"></i></a>
                                                @endif
                                                <a title="delete" class="delete btn btn-link" name="{{$data->ref_no}}_delete">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </th>
                                    @foreach ($fields as $col)
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
            </div>
                <div class="export">
                    <a target="_blank" class="btn btn-primary" href="/export" onclick="event.preventDefault(); document.getElementById('excel-form').submit();">
                        Export to Excel
                    </a>

                    <form id="excel-form" action="/export" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        <input type="text" name="file" id="file" value="New Databank" />
                        <input type="text" name="colsString" id="colsString" value="{{serialize($fields)}}" />
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
                        @foreach($data as $col=>$value)
                            @if(!in_array($col,$discard))
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="{{$data->ref_no. '_' . $j}}">{{ucwords($col)}}:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
                                                class="form-control"
                                                id="{{$data->ref_no. '_' . $j}}"
                                                value="{{$value}}" readonly/>
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
        <div class="modal fade" id="visa_{{$data->ref_no}}" role="dialog">
            <div class="modal-dialog" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add to Visa Processing</h4>
                    </div>
                    <form action="/add_to_visa" method="post" id="data-fom-{{$data->ref_no}}">
                        {{csrf_field()}}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="{{$data->ref_no. '_' . 'ref_no'}}">Ref No:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            type="text"
                                            class="form-control"
                                            id="{{$data->ref_no. '_' . 'ref_no'}}"
                                            name="ref_no"
                                            placeholder="Enter Ref No here!"
                                            value="{{$data->ref_no}}"  readonly />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="{{$data->ref_no. '_' . 'visa_process_date'}}">Visa Process Date*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            type="date"
                                            class="form-control"
                                            id="{{$data->ref_no. '_' . 'visa_process_date'}}"
                                            name="visa_process_date"
                                            placeholder="Enter Visa Process Date here!"
                                            required />
                                </div>
                            </div>
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

    <script type="text/javascript">
    @if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin')
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function (){
            $(".delete").click(function(){
                var name=$(this).attr("name");
                var val=parseInt(name.substr(0,name.lastIndexOf('_')));
                var col='ref_no';
                var result = confirm("Want to delete?");
                if (result) {
                    $.ajax({
                        url: '/delete_new',
                        type: 'post',
                        data: {
                            db_table:'{{$db_table}}',
                            w_val: val,
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
                }
            });
        });

        $(function () {
            $("td").dblclick(function () {
                var OriginalContent = $(this).text();
                OriginalContent = OriginalContent.trim();

                $(this).addClass("cellEditing");
                var myCol = $(this).index() - 1;
                var $tr = $(this).closest('tr');
                var myRow = $tr.index() + 1;


                var colArray = {!! json_encode($fields) !!} ;
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

            $.ajax({
                url: action,
                type: method,
                data: {
                    db_table:'{{$db_table}}',
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