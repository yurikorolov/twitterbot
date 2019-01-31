@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading bg-light">
                    <div style="font-size:16px; font-weight: bold; color:#565656;">Chat Tweets</div>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{session('success')}}
                    </div>
                @endif

                <div class="panel-body">
                    <div class="row" align="center">
                        <div class="col-lg-12">
                            <form class="form-inline" enctype="multipart/form-data" role="form" method="GET" action="{{'/chat_tweets'}}">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="date" placeholder="Date">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="keyword" style="width:200px;">
                                        <option value="">Select keyword</option>
                                        @foreach ($keywords as $keyword)
                                            <option value="{{$keyword->keyword}}">{{$keyword->keyword}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="user_screen_name" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="user_name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="tweet_text" placeholder="Tweet Text">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="reply" placeholder="Reply Text">
                                </div>
                                <button type="submit" class="btn btn-default">Search</button>
                            </form>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table id="example" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered hover">
                                <thead>
                                <tr>
                                    <th style="text-align: center; width:180px;">Date</th>
                                    <th style="text-align: center; width:180px;">keyword</th>
                                    <th style="text-align: center; width:170px;">User name</th>
                                    <th style="text-align: center; width:170px;">Name</th>
                                    <th style="text-align: center; width:400px;">Tweet</th>
                                    <th style="text-align: center; width:400px;">Reply</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tweets as $tweet)
                                    <tr>
                                        <td style="text-align: center;">{{ \Carbon\Carbon::createFromTimeString($tweet->created_at)->toDateString() }}</td>
                                        <td style="text-align: center;">{{ $tweet->keyword }}</td>
                                        <td style="text-align: center;"><a href="http://twitter.com/{{ $tweet->user_screen_name }}" target="_blank">{{ $tweet->user_screen_name }}</a></td>
                                        <td style="text-align: center;">{{ $tweet->user_name }}</td>
                                        <td style="text-align: center;">{{ preg_replace('/(^|\b)@\S*($|\b)/', '', $tweet->tweet_text) }}</td>
                                        <td style="text-align: center;">{{ preg_replace('/(^|\b)@\S*($|\b)/', '', $tweet->reply) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        <div align="center">{{$tweets->render()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection