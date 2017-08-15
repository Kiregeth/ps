@extends('layouts.dash_app',['title'=>'new_visa'])

@section('content')
    @php
        $fields=['ref_no','date','name','mobile_no','contact_address','email','date_of_birth', 'passport_no',
               'pp_status','local_agent','la_contact','trade','company','offer_letter_received_date','visa_process_date',
               'pp_returned_date','pp_resubmitted_date','app_status'];
        $date=['date_of_birth','offer_letter_received_date','visa_process_date','pp_returned_date','pp_resubmitted_date'];
        $discard=['photo','db_status','created_at','updated_at','app_status','vp_status','id'];
        $vf_fields=['supply_agent','ticket_no','flown_date','demand_no','visa_no'];
        $vf_required=['ticket_no'];
        $vf_date=['wp_expiry','visa_return_date','visa_issue_date','visa_expiry_date','flown_date'];
        $vf_numeric=['ticket_no'];
    @endphp
    <div class="container">
        @if(session()->has('message'))
            <h3 align="center" class="alert alert-success">{{session()->get('message')}}</h3>
        @endif
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-md-6"><h1>Visa Process</h1></div>
                    <div class="col-xs-6 col-md-6 center-blocks">
                        <form action="/new_visa" method="POST" name="search-form" id="search-form">
                            {{csrf_field()}}
                            <h5><label for="search">Search:</label></h5>
                            @php if(strpos($sel, '.') !== false){ $sel=substr($sel, strpos($sel, ".") + 1); }@endphp
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
                            <tr @if($data->app_status=='vp')
                                style='background-color: lightgreen;'
                                @elseif($data->app_status=='vr')
                                style='background-color: yellow;'
                                @elseif($data->app_status== 'vf')
                                style='background-color: lightblue;'
                                    @endif>

                                <th style="min-width: 100px; text-align: center">
                                    <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                        @if(in_array('view',session('permission')))
                                        <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$data->ref_no}}"
                                           title="view"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-link" data-toggle="modal" data-target="#remarks_{{$data->ref_no}}"
                                               title="Remarks"><i class="fa fa-comment"></i></a>
                                        @endif
                                        @if(in_array('transfer',session('permission')))
                                        <a class="cancel btn btn-link" name="{{$data->ref_no}}_cancel"
                                           title="visa cancel"><i class="fa fa-times"></i></a>
                                            @if($data->app_status!='vf' && $data->app_status!='vc' && $data->app_status!='vr')
                                                <a class="btn btn-link" data-toggle="modal" data-target="#visa_receive_{{$data->ref_no}}"
                                                   title="add to visa receive"><i class="fa fa-life-ring"></i></a>

                                            @endif
                                            @if($data->app_status==='vr')
                                                <a class="btn btn-link" data-toggle="modal" data-target="#deploy_{{$data->ref_no}}"
                                                   title="add to deployment"><i class="fa fa-paper-plane"></i></a>
                                            @endif
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
                    <input type="text" name="file" id="file" value="New Visa Process" />
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
                        @foreach($data as $col=>$value)
                            @if(!in_array($col,$discard))
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="{{$data->ref_no. '_v_' . $col}}">{{ucwords($col)}}:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
                                                class="form-control"
                                                id="{{$data->ref_no. '_v_' . $col}}"
                                                value="{{$value}}" readonly/>
                                    </div>
                                </div>
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
        <div class="modal fade" id="remarks_{{$data->ref_no}}" role="dialog">
            <div class="modal-dialog" >

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Remarks [Ref.No - {{$data->ref_no}}]</h4>
                    </div>
                    <form class="frm_remark" method="post">
                        {{csrf_field()}}
                        <div class="modal-body" >
                            <div id="mb_{{$data->ref_no}}" class="mb-class">
                                @foreach($remarks as $remark)
                                    @if($remark->ref_no===$data->ref_no)
                                        <div class="bg-primary row dbt">
                                            <div class="col-md-8" style="word-wrap: break-word;">{{$remark->remark}}</div>
                                            <div class="col-md-2" style="font-weight:bold;">[{{$remark->user}}]</div>
                                            <div class="col-md-2">{{$remark->time}}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row dbt">
                                <div class="col-md-12"><input style="margin-top:10px !important;" autofocus class="form-control" placeholder="Add Remark" id="in_{{$data->ref_no}}"></div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    @endforeach

    @foreach($datas as $data)
        <div class="modal fade" id="deploy_{{$data->ref_no}}" role="dialog">
            <div class="modal-dialog" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add to Deployment</h4>
                    </div>
                    <form action="/add_to_deployment" method="post" id="data-form-{{$data->ref_no}}">
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
                            @foreach($vf_fields as $col)
                                <div class="row">
                                    <div class="col-xs-3 col-md-3">
                                        <label class="control-label pull-right"
                                               for="{{$data->ref_no. '_' . $col}}">{{ucwords(preg_replace('/_+/', ' ', $col))}}:@if(in_array($col,$vf_required)) *@endif</label>
                                    </div>
                                    @if(in_array($col,$vf_date))
                                        @php $type='date'; @endphp
                                    @elseif(in_array($col,$vf_numeric))
                                        @php $type='number'; @endphp
                                    @else
                                        @php $type='text'; @endphp
                                    @endif
                                    <div class="col-xs-7 col-md-7"><input
                                                type="{{$type}}"
                                                class="form-control"
                                                id="{{$data->ref_no. '_' . $col}}"
                                                name="{{$col}}"
                                                placeholder="Enter {{ucwords(preg_replace('/_+/', ' ', $col))}} Date here! @if(in_array($col,$vf_required)) * @endif"
                                                @if(in_array($col,$vf_required)) required @endif
                                                />
                                    </div>
                                </div>
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

    @foreach($datas as $data)
        <div class="modal fade" id="visa_receive_{{$data->ref_no}}" role="dialog">
            <div class="modal-dialog" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add to Visa Receive</h4>
                    </div>
                    <form action="/add_to_visa_receive" method="post" id="data-form-{{$data->ref_no}}">
                        {{csrf_field()}}
                        <div class="modal-body">
                            <input type="hidden" name="db_table" value="{{$db_table}}"/>
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
                                           for="{{$data->ref_no. '_' . 'vr_date'}}">Visa Receive Date*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            type="date"
                                            class="form-control"
                                            id="{{$data->ref_no. '_' . 'vr_date'}}"
                                            name="vr_date"
                                            placeholder="Enter Visa Receive Date here!"
                                            required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="{{$data->ref_no. '_' . 'visa_issue_date'}}">Visa Issue Date*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            type="date"
                                            class="form-control"
                                            id="{{$data->ref_no. '_' . 'visa_issue_date'}}"
                                            name="visa_issue_date"
                                            placeholder="Enter Visa Issue Date here!"
                                            required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="{{$data->ref_no. '_' . 'visa_expiry_date'}}">Visa Expiry Date*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            type="date"
                                            class="form-control"
                                            id="{{$data->ref_no. '_' . 'visa_expiry_date'}}"
                                            name="visa_expiry_date"
                                            placeholder="Enter Visa Expiry Date here!"
                                            required />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="{{$data->ref_no. '_' . 'trade'}}">Trade*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            class="form-control"
                                            id="{{$data->ref_no. '_' . 'trade'}}"
                                            name="trade"
                                            placeholder="Enter trade here! *"
                                            value="{{$data->trade}}"
                                            required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 col-md-3">
                                    <label class="control-label pull-right"
                                           for="{{$data->ref_no. '_' . 'company'}}">Company*:</label>
                                </div>
                                <div class="col-xs-7 col-md-7"><input
                                            class="form-control"
                                            id="{{$data->ref_no. '_' . 'company'}}"
                                            name="company"
                                            placeholder="Enter company here!"
                                            value="{{$data->company}}"
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
        @if(in_array('transfer',session('permission')))
        $(function (){
            $(".cancel").click(function(){
                var name=$(this).attr("name");
                var val=parseInt(name.substr(0,name.lastIndexOf('_')));
                var col='ref_no';
                var result = confirm("Want to cancel?");
                if (result) {
                    $.post('/cancel_new', {'db_table':'{{$db_table}}','w_val': val,'w_col': col,'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):location.reload(true);});
                }


            });
        });
        @endif
        @if(in_array('edit',session('permission')))
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
            $.post(action, {'db_table':'{{$db_table}}','val': value,'col': column,'w_col': where_col,'w_val': where_val,'_token':$('input[name=_token]').val()}, function(response) {(response)?alert(response):null});
            return false;
        }
        @endif

        $('.frm_remark').bind('keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                var id=e.target.id.substring( e.target.id.indexOf('_') + 1 );
                var now= (new Date ((new Date((new Date(new Date())).toISOString() )).getTime() - ((new Date()).getTimezoneOffset()*60000))).toISOString().slice(0, 19).replace('T', ' ');
                var val=$("#in_"+id).val();
//            var now=new Date();
//            var mnth;
//            if((now.getDate()+1)<10)
//                mnth='0'+now.getDate()+1;
//            else
//                mnth=now.getDate()+1;
//            var nowString=now.getFullYear()+"-"+mnth+"-"+now.getDate()+" "+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();

                $.post('/add_remark', {'id':id,'remark': val,'_token':$('input[name=_token]').val()}, function(response) {
                    if(response)
                    {
                        alert(response)
                    }
                    else
                    {
                        $("#mb_"+id).prepend(
                            "<div class='bg-primary row dbt'>"+
                            "<div class='col-md-8' style='word-wrap: break-word;'>"+val+"</div>"+
                            "<div class='col-md-2' style='font-weight: bold;'>"+"[{{Auth::user()->uname}}]"+"</div>"+
                            "<div class='col-md-2'>"+now+"</div>"+
                            "</div>"
                        );
                    }
                });
                document.getElementById("in_"+id).value="";
//            var modal_div = document.getElementById("my_modal");
//            var new_element = document.createElement("div");
//            modal_div.appendChild(new_element);
                return false;
            }
        });

    </script>


@endsection