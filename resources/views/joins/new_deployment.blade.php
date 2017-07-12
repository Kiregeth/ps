@extends('layouts.dash_app',['title'=>'new_deployments'])

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
        min-width: 100px;
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
$fields=['ref_no','date','name','mobile_no','contact_address','email','date_of_birth', 'passport_no',
'pp_status','local_agent','la_contact','trade','company','offer_letter_received_date','visa_process_date',
'pp_returned_date','pp_resubmitted_date','remarks','db_status'];
$discard=['photo','db_status','created_at','updated_at','app_status','vp_status','id'];
@endphp
<div class="container">
    @if(session()->has('message'))
    <h3 align="center" class="alert alert-success">{{session()->get('message')}}</h3>
    @endif
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="row">
                <div class="col-xs-6 col-md-6"><h1>Deployment</h1></div>
                <div class="col-xs-6 col-md-6 center-blocks">
                    <form action="/new_deployment" method="POST" name="search-form" id="search-form">
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
            <form id='ajax-form' method='post' action='/'>
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
                    @foreach ($datas as $data)
                    <tr>

                        <th style="min-width: 100px; text-align: center">
                            <div class="center-block" style="margin-top: auto;margin-bottom: auto; ">

                                <a class="btn btn-link" data-toggle="modal" data-target="#modal_{{$data->ref_no}}"
                                   title="view"><i class="fa fa-eye"></i></a>
                                <a class="cancel btn btn-link" name="{{$data->ref_no}}_cancel"
                                   title="visa cancel"><i class="fa fa-times"></i></a>
                                @if($data->vp_status!='vf' && $data->vp_status!='vc')
                                <a class="btn btn-link" data-toggle="modal" data-target="#deploy_{{$data->ref_no}}"
                                   title="add to deployment"><i class="fa fa-paper-plane"></i></a>
                                @endif
                            </div>
                        </th>
                        @foreach ($fields as $col)
                        @if(!in_array($col,$discard))
                        <td> {{$data->$col}} </td>
                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
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


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function (){
        $(".cancel").click(function(){
            var name=$(this).attr("name");
            var val=parseInt(name.substr(0,name.lastIndexOf('_')));
            var col='ref_no';
            var result = confirm("Want to cancel?");
            if (result) {
                $.ajax({
                    url: '/cancel_new',
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

</script>


@endsection