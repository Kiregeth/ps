@extends('layouts.dash_app',['title'=>'add_user'])

@section('content')
    <style>
        .form-group{
            margin-bottom: 0px;
        }
        .form-control{
            background-color: white;
        }
        label{
            line-height: 3em;
        }
    </style>
    @php
        $discard=['id','created_at','updated_at','remember_token'];
        $required=['uname','name','email','password'];
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                @if(session()->has('message'))
                    <h1 align="center" class="alert alert-success">{{session()->get('message')}}</h1>
                @endif
                <h3>Add New User</h3>
                <form method="post" action="" name="add-user" id="add-user">
                    {{csrf_field()}}
                    @foreach($cols as $col)
                        @if(!in_array($col,$discard))
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="control-label" for="{{$col}}">{{strtoupper($col)}} @if(in_array($col,$required)) * @endif :</label>
                                </div>
                                <div class="col-md-8">
                                    @if($col=='password')
                                        <input name="{{$col}}" id="{{$col}}" class="form-control" type="password" placeholder="{{strtoupper($col)}} @if(in_array($col,$required)) * @endif" @if(in_array($col,$required)) required @endif/>
                                    @elseif($col=='role')
                                        <select name="{{$col}}" id="{{$col}}" class="form-control">
                                            @foreach($roles as $role)
                                                <option value="{{$role->role}}">{{$role->role}}</option>
                                            @endforeach
                                        </select>
                                    @elseif($col=="email")
                                        <input name="{{$col}}" id="{{$col}}" class="form-control" type="email" placeholder="{{strtoupper($col)}} @if(in_array($col,$required)) * @endif" @if(in_array($col,$required)) required @endif/>
                                    @else
                                        <input name="{{$col}}" id="{{$col}}" class="form-control" type="text" placeholder="{{strtoupper($col)}} @if(in_array($col,$required)) * @endif" @if(in_array($col,$required)) required @endif/>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="form-group">
                        <div class="pull-left">
                            <input class="btn btn-primary" type="submit" value="Add User">
                        </div>
                        <br/>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection