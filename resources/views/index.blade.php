@extends('layouts.home')
@section('content')
    
    <div class="container-fluid">
    	<div class="row content">
    		<div class="sidenav col-2">
    			<div class="sidenav-top" ><h4>QR Code Management</h4></div>
	    		<ul class="nav nav-pills flex-column">
	    			<li class="nav-item"><a class="nav-link active" href="">View QR Code</a></li>
	    			<li class="nav-item"><a class="nav-link " href="add">Add QR Code</a></li>
                    <li class="nav-item"><a class="nav-link disabled" href="">Update QR Code</a></li>
                    <li class="nav-item"><a class="nav-link" href="/recycle">Recycle Bin</a></li>
                    <li class="nav-item"><a class="nav-link" href="/uac">User Account Control</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
	    		</ul>
	    	</div>
            <div class="main-content col-10">
                <div class="table-top"></div>
                <table class="table table-striped table-responsive{md}">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>tag</th>
                            <th>ga_original_url</th>
                            <th>ga_source</th>
                            <th>ga_medium</th>
                            <th>ga_name</th>
                            <th>ga_term</th>
                            <th>ga_content</th>
                            <th>note</th>
                            <th>created_url</th>
                            <th>created_date</th>
                            <th>Manipulation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($code_list as $item)
                            @if($item->flag!=0)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->tag}}</td>
                                <td>{{$item->ga_original_url}}</td>
                                <td>{{$item->ga_source}}</td>
                                <td>{{$item->ga_medium}}</td>
                                <td>{{$item->ga_name}}</td>
                                <td>{{$item->ga_term}}</td>
                                <td>{{$item->ga_content}}</td>
                                <td>{{$item->note}}</td>
                                <td>{{$item->created_url}}</td>
                                <td>{{$item->created_date}}</td>
                                <td><a href="{{'/download/'.$item->id}}" target="_blank" download="">Download</a> <a href="{{'/update/'.$item->id}}">Update</a> <a href="{{'/delete/'.$item->id}}" onclick="var res = confirm('Are you sure you want to delete this QR code?');if(!res){return false;}">Delete</a></td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
    	</div>
    </div>
@endsection
