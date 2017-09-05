@extends('layouts.dash_app',['title'=>'online_forms'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-4 col-md-4"><h1>Online Forms <a title="refresh" href="/refresh" class="btn btn-xs btn-default"><i class="fa fa-refresh" aria-hidden="true"></i></a></h1></div>
            {{--<form action="/new_deployment" method="POST" name="search-form" id="search-form">--}}
                {{--{{csrf_field()}}--}}
                {{--<div class="col-xs-4 col-md-4 ">--}}
                    {{--<h5 align="center"><label for="search">Search:</label></h5>--}}
                    {{--@php if(strpos($sel, '.') !== false) $sel=substr($sel, strpos($sel, ".") + 1) @endphp--}}
                    {{--<select class="selectpicker" name="sel" id="sel" data-style="btn-info">--}}
                        {{--@foreach($fields as $col)--}}
                            {{--@if(!in_array($col,$discard))--}}
                                {{--<option value="{{$col}}" @if($sel===$col){{'selected'}}@endif>{{ucwords($col)}}</option>--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                    {{--</select>--}}

                    {{--<input name="search" id="search" type="text" value="{{$search}}" placeholder="Search"/>--}}

                {{--</div>--}}
                {{--<div class="col-xs-4 col-md-4">--}}
                    {{--<h5><label for="page_size">Page Size:</label></h5>--}}
                    {{--<select name="page_size" class="selectpicker" data-style="btn-info">--}}
                        {{--<option value="20" @if($limit==20) selected @endif>20</option>--}}
                        {{--<option value="40" @if($limit==40) selected @endif>40</option>--}}
                        {{--<option value="60" @if($limit==60) selected @endif>60</option>--}}
                        {{--<option value="80" @if($limit==80) selected @endif>80</option>--}}
                    {{--</select>--}}
                    {{--<input type="submit" value="Go" />--}}
                {{--</div>--}}

            {{--</form>--}}
        </div>
    </div>
@endsection