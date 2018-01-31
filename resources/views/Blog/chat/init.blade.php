@extends('layouts.chat')
@section('content')

<div class="container-fluid">
    <div class="row" >
        <div class="col-lg-12">
            <h2>ChatRoom</h2>
        </div>
    </div>
    <div class="row" >
        <div class="col-lg-12">
            <div id="app">
                <chat-log></chat-log>
                <chat-composer></chat-composer>

            </div>
            <message></message>
            <example></example>
        </div>
    </div>
</div>


<script src="/js/app.js"></script>
@endsection