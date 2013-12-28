@section('topNav')

<div id="nav_wrapper" class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="dashboard.php"><i class="glyphicon glyphicon-home"></i> WPA9 - Project Manager </a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li><p class="navbar-text"><img src="{{Session::get('photo')}}" alt="profile photo" width="20px" class="img-circle">&nbsp;&nbsp;{{Session::get('member')}}</p></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i  class="glyphicon glyphicon-cog"></i> Setting <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="user_account.php">Account Setting</a></li>
									<li><a href="member_entry.php">Member Setting</a></li>
									<li><a href="organization.php">Organization Setting</a></li>

								</ul>
							</li>

							<li>
								<a href="{{route('logout')}}"><i  class="glyphicon glyphicon-off"></i> Log Out </a>
							</li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</nav>
			</div>
		</div> <!-- end of nav_wrapper -->
		
@show