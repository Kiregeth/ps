@extends('layouts.dash_app',['title'=>'interview'])

@section('content')
    <div class="container">
    @php
        $fields=['ref_no','name','passport_no','trade'];
        $discard=[];
    @endphp
    @if(session()->has('message'))
        <h3 align="center" class="alert alert-success">{{session()->get('message')}}</h3>
    @endif
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-4  col-md-4"><h1>Interview List</h1></div>
                    <form action="/interview" method="POST" name="search-form" id="search-form">
                        {{csrf_field()}}
                        <div class="col-xs-4 col-md-4 ">
                            <h5 align="center"><label for="search">Search:</label></h5>
                            @php if(strpos($sel, '.') !== false) $sel=substr($sel, strpos($sel, ".") + 1) @endphp
                            <select class="selectpicker" name="sel" id="sel" data-style="btn-info">
                                @foreach($fields as $col)
                                    @if(!in_array($col,$discard))
                                        <option value="{{$col}}" @if($sel===$col){{'selected'}}@endif>{{ucwords($col)}}</option>
                                    @endif
                                @endforeach
                            </select>

                            <input name="search" id="search" type="text" value="{{$search}}" placeholder="Search"/>

                        </div>
                        <div class="col-xs-4 col-md-4">
                            <h5><label for="page_size">Page Size:</label></h5>
                            <select name="page_size" class="selectpicker" data-style="btn-info">
                                <option value="20" @if($limit==20) selected @endif>20</option>
                                <option value="40" @if($limit==40) selected @endif>40</option>
                                <option value="60" @if($limit==60) selected @endif>60</option>
                                <option value="80" @if($limit==80) selected @endif>80</option>
                            </select>
                            <input type="submit" value="Go" />
                        </div>
                    </form>
                </div>
                <br/>
            </div>
        </div>
        <br/>
        <form id='ajax-form' method='post'>
            {{ csrf_field() }}
            <table style="width: 85% !important" class="table table-striped table-bordered editableTable" id="myTable">
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
                    <tr>
                        <th style="min-width: 100px; text-align: center">
                            <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">
                                @if(in_array('view',session('permission')))
                                    <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$data->ref_no}}"
                                       title="view"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-link" data-toggle="modal" data-target="#remarks_{{$data->ref_no}}"
                                       title="Remarks"><i class="fa fa-comment"></i></a>
                                @endif
                                @if(in_array('transfer',session('permission')))
                                    @if($data->app_status!='vp' && $data->app_status!='vr' && $data->app_status!='vf' && $data->app_status!='int')
                                        <a class="btn btn-link" href="/add_to_interview" onclick="event.preventDefault();
                                                     document.getElementById('int-form').submit();"
                                           title="add to interview list"><i class="fa fa-question-circle"></i></a>


                                        <form id="int-form" action="/add_to_interview" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="ref_no" value="{{$data->ref_no}}">
                                        </form>
                                        <a class="btn btn-link" data-toggle="modal" data-target="#visa_{{$data->ref_no}}"
                                           title="add to visa processing"><i class="fa fa-forward"></i></a>
                                        {{--<a class="btn btn-link" data-toggle="modal" data-target="#visa_receive_{{$data->ref_no}}"--}}
                                        {{--title="add to visa receive"><i class="fa fa-life-ring"></i></a>--}}
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
                            @if($col!='created_at' && $col!='updated_at' && $col!='app_status')
                                <div class="row">
                                    <div class="col-xs-4 col-md-4"><label class="control-label pull-right"
                                                                          for="{{$data->ref_no. '_' . $j}}">{{$col}}:</label>
                                    </div>
                                    <div class="col-xs-8 col-md-8"><input
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
    <script>
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