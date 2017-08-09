@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class = "panel panel-default">
                <div class="panel-heading">Who's Online</div>
                <WhosOnline></WhosOnline>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
