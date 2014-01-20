@extends('layouts.base')

@section('body')
	<div class="container" id="member_detail">
		@include('partials.topNav')
		<div id="breadcrumb_wrapper" class="row text-right">
			<ol class="breadcrumb">
				<li><a href="{{route('home')}}">Home</a></li>				
				<li><a href="{{route('member_list')}}">Members List</a></li>
				<li class="active">Members Detail</li>
			</ol>
		</div> <!-- end of breadcrumb_wrapper -->
		<div id="main_content_wrapper" class="row">
			@include('partials.sidebar')
			<div id="main_content" class="col-md-10">
				<div class="row">
					<div id="panel_wrapper" class="col-md-12">					
						<div class="panel panel-primary">
						  	<div class="panel-heading">
						    	<h3 class="panel-title">{{Lang::get('caption.title.member_detail')}} {{ $para['member']->member }}</h3>
						  	</div>
						  	<div class="panel-body">	
						  		{{ Form::open(array(
									'method'		=> 'post',
									'route'			=> 'member_update',
									'autocomplete'	=> 'off',
									'class'			=> 'form-horizontal',
									'enctype'		=> 'multipart/form-data'
									))
								}}		
								{{ Form::hidden('memberId',0, array("class" => 'form-control', 'id' => 'txtMemberId'
								)) }}
								{{ Form::hidden('key','', array("class" => 'form-control', 'id' => 'txtKey'
								)) }}	
								{{ Form::hidden('value','', array("class" => 'form-control', 'id' => 'txtValue'
								)) }}				
							  	<p class="col-md-2 col-md-offset-5 text-left">

							  		<img src="{{ $para['member']->photoPath }}" class="img-rounded text-center" alt="" width="100" id='userPhoto'/>
							  		<div class="controls txtShow" id="photo_control">
										<input id="uploadPhoto" type="file" onchange="showPhoto(this);" class='form-control' name='profile' value="{{Input::old('profile')}}"/>					
										<div id="falsebtn" class="btn btn-default">Browse</div><span id="photo_warn">{{Lang::get('caption.label.member_detail.photo_warn')}}</span>					
									</div>
							  	</p>
							  	{{ Form::submit('Submit', array('class' => 'btn btn-default hide', 'id'=>'btnSubmit')) }}
							  	{{ Form::close() }}	 
							  	<div class="col-md-3 col-md-offset-1">
							  		<select class="form-control text-center" id="cboMember">
							  		<option>Choose Other</option>
										@foreach($para['members'] as $mber)
											@if($para['member']->member==$mber->member)						
												<option value="{{$mber->memberId}}" disabled="true">{{ $mber->member }}</option>		
											@else
												<option value="{{$mber->memberId}}">{{ $mber->member }}</option>
											@endif
										@endforeach
									</select>
									<a id="memChoose"></a>
								</div>
								{{ Form::hidden('mId',$para['member']->memberId, array("class" => 'form-control', 'id' => 'mId'
								)) }}
								<div class="row">
									<div class="col-md-8 col-md-offset-3">
										<p class="textclear row">
											<span class="col-md-4 text-right"><strong>{{Lang::get('caption.label.member_detail.member_name')}} :</strong></span><span class="col-md-8 text-left lblHide">{{ $para['member']->member }}</span>
											{{ Form::text('member', $para['member']->member, array("class" => 'form-control txtShow'
												)) 
											}}
										</p>
										<p class="textclear row">
											<span class="col-md-4 text-right"><strong>{{Lang::get('caption.label.member_detail.role')}} :</strong></span><span class="col-md-8 text-left">{{ $para['member']->role }}</span>
										</p>
										<?php 
											$date = date_create($para['member']->created_at);
											$jDate = $date->format('d-M-Y');
										?>
										<p class="textclear row">
											<span class="col-md-4 text-right"><strong>{{Lang::get('caption.label.member_detail.j_date')}} :</strong></span><span class="col-md-8 text-left">{{ $jDate }}</span>
										</p>
										<?php
											if($para['member']->phone == null)$phone='&nbsp';
											else $phone = $para['member']->phone;
										?>
										<p class="textclear row">
											<span class="col-md-4 text-right"><strong>{{Lang::get('caption.label.member_detail.ph')}} :</strong></span><span class="col-md-8 text-left lblHide">{{ $phone }}</span>
											{{ Form::text('phone', $para['member']->phone, array("class" => 'form-control txtShow', 'onkeydown' => 'validateNumber(event)')) 
											}}
										</p>
										<?php
											if($para['member']->address == null)$address = '&nbsp';
											else $address = $para['member']->address;
										?>
										<p class="textclear row">
											<span class="col-md-4 text-right"><strong>{{Lang::get('caption.label.member_detail.add')}} :</strong></span><span class="col-md-8 text-left lblHide">{{ $address }}</span>
											{{ Form::text('address', $para['member']->address, array("class" => 'form-control txtShow')) 
											}}
										</p>
										<p class="textclear row">
											<span class="col-md-4 text-right"><strong>{{Lang::get('caption.label.member_detail.username')}} :</strong></span><span class="col-md-8 text-left lblHide">{{ $para['member']->username }}</span>
											{{ Form::text('username', $para['member']->username, array("class" => 'form-control inputUsername txtShow')) 
											}}
										</p>
										<p class="error_msg">
											@if($errors->has('username'))
												@foreach($errors->get('username') as $username_errors)
													{{ $username_errors }}
												@endforeach
											@endif
										</p>
										<p class="textclear row">
											<span class="col-md-4 text-right"><strong>{{Lang::get('caption.label.member_detail.email')}} :</strong></span><span class="col-md-8 text-left lblHide">{{ $para['member']->email }}</span>
											{{ Form::text('email', $para['member']->email, array("class" => 'form-control txtShow'
												)) 
											}}
										</p>
										<p class="error_msg">
											@if($errors->has('email'))
												@foreach($errors->get('email') as $email_errors)
													{{ $email_errors }}
												@endforeach
											@endif
										</p>										
										<p class="textclear row passField">
											<span class="col-md-4 text-right"><strong>{{Lang::get('caption.label.member_detail.pass')}} :</strong></span>
											{{ Form::password('password', array("class" => 'form-control inputPassword txtShow', 'placeholder'=>'***********'
											)) 
										}}										
										</p>
										<p class="error_msg">
											@if($errors->has('password'))
												@foreach($errors->get('password') as $password_errors)
													{{ $password_errors }}
												@endforeach
											@endif
										</p>
										<p class="textclear row passField">
											<span class="col-md-4 text-right"><strong>{{Lang::get('caption.label.member_detail.c_pass')}} :</strong></span>
											{{ Form::password('password_confirmation', array("class" => 'form-control inputPassword txtShow password_confirmation', 'placeholder'=>'***********'
											)) 
										}}										
										</p>
										<p class="error_msg">
											@if($errors->has('password_confirmation'))
												@foreach($errors->get('password_confirmation') as $password_errors)
													{{ "confirm password field is required" }}
												@endforeach
											@endif
										</p>										
									</div>
								</div>										
							</div>
						</div> <!--- end of panel_wrapper -->				
					</div> <!-- end of main_content -->
				</div> <!-- end of main_content_wrapper -->
			</div>
		</div>
	</div>

<script>
	function showPhoto(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#userPhoto')
                    .attr('src', e.target.result)					                
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

	$(document).ready( function() {
		var temp;var str=0;
		$('#memChoose').hide();
		$('.txtShow, .passField').hide();
		
		$('#falsebtn').click(function(){
			$('#txtMemberId').val($('#mId').val());
			str=1;
			$('#txtKey').val('username');
			$('#txtValue').val($('.inputUsername').val());
		    $("#uploadPhoto").click();
		});

		$("#userPhoto").load(function(){
			if($('#txtKey').val()=='username' && str!=0){				
				$('#btnSubmit').click();
			}
		});

		$("#userPhoto").click(function(){
			$('.lblHide').hide();
			$('.txtShow, .passField').show();
			$('#falsebtn').click();
		});

		$('#cboMember').change(function(){
			$memberId = $('#cboMember option:selected').val();
			var url = '/member_detail?memberId=' + $memberId;
			$('#memChoose').attr('href', url);	
			$('#memChoose')[0].click();
		});

		$('.lblHide').click(function(){
			$('.lblHide').hide();
			$('.txtShow, .passField').show();
			$tmp = $(this).closest('p');
			$tmp.find('.txtShow').focus().select();			
		});

		$('.txtShow').focus(function(){
			temp = $(this).val();
		});

		$('.txtShow').blur(function(){
			$tmp = $(this).closest('.row');
			$lbl = $tmp.find('strong').text();
			$lbl = $lbl.slice(0, $lbl.length-2);

			if($(this).val()==''){				
				alert($lbl + ' is empty!');
				location.reload();
			}

			if(temp != $(this).val()){

				if($(this).attr('name')=='password' || $(this).attr('name')=='password_confirmation'){
					if($('.inputPassword').val()==''||$('.password_confirmation').val()==''){
						if($(this).val().length < 4){
							alert('Password length must be at least 4 characters');
							location.reload();
						}
					}
					else{
						if($('.inputPassword').val() != $('.password_confirmation').val()){
							alert('Password and Confirm Password are not matched');
							location.reload();
						}
						$('#txtKey').val('password');	
						$('#txtValue').val($(this).val());
						$('#txtMemberId').val($('#mId').val());
						$('#btnSubmit').click();		
					}
					return;
				}				

				$('#txtKey').val($(this).attr('name'));	
				$('#txtValue').val($(this).val());
				$('#txtMemberId').val($('#mId').val());
				$('#btnSubmit').click();				
			}
		});		
		
		$('.txtShow').keypress(function(e){
			var code = e.keyCode || e.which;
			if(code == 13){
				$(this).blur();
			}
		});
	});
</script>
@stop