@extends('layouts.home')

@section("style")
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('/resources/assets/css/uac.css?v=0.1')}}">
@endsection

@section('content')
    
    <div class="container-fluid">
    	<div class="row content">
    		<div class="sidenav col-2">
    			<div class="sidenav-top" ><h4>QR Code Management</h4></div>
	    		<ul class="nav nav-pills flex-column">
	    			<li class="nav-item"><a class="nav-link" href="/">View QR Code</a></li>
	    			<li class="nav-item"><a class="nav-link " href="/add">Add QR Code</a></li>
                    <li class="nav-item"><a class="nav-link disabled" href="">Update QR Code</a></li>
                    <li class="nav-item"><a class="nav-link" href="/recycle">Recycle Bin</a></li>
                    <li class="nav-item"><a class="nav-link active" href="">User Account Control</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
	    		</ul>
	    	</div>
            <div class="main-content col-10">
                <div class="table-top"></div>
                <!-- alert start-->
                @if(session('msg') and session('msg')=='incorrect password')
                    <p class="alert alert-danger">Incorrect current password</p>
                @endif
                @if(session('msg') and session('msg')=='update success')
                    <p class="alert alert-success">Password has been changed</p>
                @endif
                @if(session('msg') and session('msg')=='username or password is required')
                    <p class="alert alert-danger">Username or password is required</p>
                @endif
                @if(session('msg') and session('msg')=='added')
                    <p class="alert alert-success">User has been created</p>
                @endif
                @if(session('msg') and session('msg')=='admin can not be deleted')
                    <p class="alert alert-danger">Admin can not be deleted</p>
                @endif
                <!-- alert end -->
                <!-- Modal start-->
                <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="" method="post">
                      {{csrf_field()}}
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="cur_password" class="col-form-label">Current Password</label>
                              <input type="password" class="form-control" name="cur_password" required>
                            </div>
                            <div class="form-group">
                              <label for="new_password" class="col-form-label">New password</label>
                              <input type="password" class="form-control" name="new_password" required>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                       </form>
                    </div>
                  </div>
                </div>
                <!-- Modal end -->

                <!-- Modal start -->
                 <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="addUser" method="post">
                      {{csrf_field()}}
                      <!-- 实现提交表单时具有当前用户的id -->
                      <input type="hidden" id="target_id" name="id" value=""> 
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="username" class="col-form-label">Username</label>
                              <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                              <label for="password" class="col-form-label">Password</label>
                              <input type="password" class="form-control" name="password" required>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Done</button>
                          </div>
                       </form>
                    </div>
                  </div>
                </div>
                <!-- Modal end -->
                    
                <table class="table table-striped table-responsive{md}">
                    <h4>Valid Users</h4>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>Created Date</th>
                            <th>Manipulation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $item)
                            @if($item->flag!=0)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->date}}</td>
                                <td><a href="" id="changePasswordBtn" data-toggle="modal" data-target="#changePassword" onclick="setTargetId({{$item->id}})">Change Password</a> <a href="{{'/deleteUser/'.$item->id}}" onclick="var res = confirm('Are you sure you want to delete this user?');if(!res){return false;}">Delete</a></td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="table-top"></div>
                <table class="table table-striped table-responsive{md}">
                    <h4>Invalid Users</h4>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>Created Date</th>
                            <th>Manipulation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $item)
                            @if($item->flag ==0)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->date}}</td>
                                <td><a href="{{'/rollbackUser/'.$item->id}}">Rollback</a></td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="addUser">
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addUser">
                    <i class="fas fa-plus-circle"></i> Add User</button>
                </div>
            </div>
    	</div>
    </div>
    
@endsection

@section('script')
<!-- 将值传递给表单中 -->
<script>
    function setTargetId(id){
        document.getElementById('target_id').setAttribute('value',id);
    }
</script>
@endsection

