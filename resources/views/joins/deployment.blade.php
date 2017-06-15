@extends('layouts.dash_app',['title'=>'deployment'])

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
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <h1>Deployment</h1>
            </div>
        </div>
    </div>


@endsection