@extends('layouts.home')
@section('content')
    <div class="container-fluid">
    	<div class="row content">
    		<div class="sidenav col-2">
    			<div class="sidenav-top" ><h4>QR Code Management</h4></div>
	    		<ul class="nav nav-pills flex-column">
	    			<li class="nav-item"><a class="nav-link" href="/">View QR Code</a></li>
	    			<li class="nav-item"><a class="nav-link" href="/add">Add QR Code</a></li>
                    <li class="nav-item"><a class="nav-link active" href="">Update QR Code</a></li>
                    <li class="nav-item"><a class="nav-link" href="/recycle">Recycle Bin</a></li>
                    <li class="nav-item"><a class="nav-link" href="/uac">User Account Control</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
	    		</ul>
	    	</div>
            <div class="main-content col-10">
                <div class="form-top"></div>
                <form action="" method="POST" class="col-10">
                    {{csrf_field()}}
                    @if(count($errors)>0)
                        <p class="alert alert-danger">Every fields(except Note) should be filled.</p>
                    @endif
                    @if(session('success'))
                        <p class="alert alert-success">QR Code has been updated.</p>
                    @endif
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label for="tag">TAG</label>
                            <input type="tag" class="form-control" name="tag" value="{{$code_list[$id-1]['tag']}}">
                        </div>
                        <div class="form-group col-8">
                            <label for="ga_original_url">Original URL</label>
                            <input type="ga_original_url" class="form-control" name="ga_original_url" value="{{$code_list[$id-1]['ga_original_url']}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="ga_source">Source</label>
                            <input type="ga_source" class="form-control" name="ga_source" value="{{$code_list[$id-1]['ga_source']}}">
                        </div>
                        <div class="form-group col-6">
                            <label for="ga_medium">Medium</label>
                            <input type="ga_medium" class="form-control" name="ga_medium" value="{{$code_list[$id-1]['ga_medium']}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="ga_name">Name</label>
                            <input type="ga_name" class="form-control" name="ga_name" value="{{$code_list[$id-1]['ga_name']}}">
                        </div>
                        <div class="form-group col-6">
                            <label for="ga_term">Term</label>
                            <input type="ga_term" class="form-control" name="ga_term" value="{{$code_list[$id-1]['ga_term']}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ga_content">Content</label>
                        <textarea type="ga_content" class="form-control" name="ga_content" rows="5">{{$code_list[$id-1]['ga_content']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <input type="note" class="form-control" name="note" value="{{$code_list[$id-1]['note']}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
    	</div>
    </div>
@endsection
