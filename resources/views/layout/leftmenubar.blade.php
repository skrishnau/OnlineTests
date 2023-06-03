
<?php
	//$route = url()->current();
	$route  = Illuminate\Support\Facades\Route::currentRouteName(); //use Illuminate\Support\Facades\Route;
	// the $route is in format 'questionpaper.index' , so lets split that
	$controller = preg_split('/[.]/', $route)[0];
	//the below commented lines are valid .. neec to learn more about these
	// $route = app('request')->route();
	// $action = app('request')->route()->getAction();
?>



{{-- MENU --}}
{{-- <div class="text-uppercase" style="padding-top: 1px; width: 100%;">

	<div class="card-header pl-4 bg-dark text-light">Menu</div>
	<div class="list-group">
		
	</div>
</div> --}}

{{-- SETUP --}}
<div class="text-uppercase text-light" style="padding-top: 1px; width: 100%;">
	{{-- <div class="card-header bg-dark text-light">Papers</div> --}}
	<ul class="nav flex-column">
		@guest
			<li class="nav-item">
				<a class="nav-link">Take Test</a>
			</li>
		@else
			 @student
				<li class="nav-item">
					<a class="nav-link" href="{{route('candidate.exams')}}">My Exams</a>
				</li>
			@endstudent

			@teacher
				<li class="nav-item">
					<a class="nav-link" href="{{route('paper.index')}}">Papers</a>
				</li>
				<li class="nav-item">
					<a class="nav-link">Exams</a>
				</li>
				<li class="nav-item">
					<a class="nav-link">Sessions</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{route('user.index')}}">Users</a>
				</li>
			@endteacher
		@endguest
	</ul>
	{{-- <div class="">Papers</div>
	<div class="list-group">
	</div>
	<div class="">Exams</div>
	<div class="list-group">
	</div>
	<div class="">Candidates</div>
	<div class="list-group">
	</div>--}}
	<div class="list-group"> 
	{{--<a class="list-group-item {{$controller == 'questionpaper' ? 'list-group-item-success':''}}" href="{{route('questionpaper.index')}}">Question Papers</a>--}}
		{{-- <a class="list-group-item list-group-item-secondary {{$controller == 'school' ? 'list-group-item-success':''}}" href="{{route('school.index')}}">Schools</a>
		<a class="list-group-item {{$controller == 'subject' ? 'list-group-item-success':''}}" href="{{route('subject.index')}}">Subjects</a>
		<a class="list-group-item  {{$controller == 'terminal' ? 'list-group-item-success':''}}" href="{{route('terminal.index')}}">Terminals</a> --}}
		{{-- <a class="list-group-item {{$controller == 'year' ? 'list-group-item-success':''}}" href="{{route('year.index')}}">Years</a> --}}
		{{-- <a class="list-group-item {{$controller == 'dependency' ? 'list-group-item-success':''}}" href="{{route('dependency.index')}}">Dependencies</a> --}}
		{{-- <div class="card-header bg-dark text-light">Question Paper</div>
		<a class="list-group-item  {{$controller == 'group' ? 'list-group-item-success':''}}" href="{{route('group.index')}}">Que.Groupings</a>
		<a class="list-group-item  {{$controller == 'nature' ? 'list-group-item-success':''}}" href="{{route('nature.index')}}">Que.Natures</a>
		<a class="list-group-item  {{$controller == 'marks' ? 'list-group-item-success':''}}" href="{{route('marks.index')}}">Mark Types</a> --}}
		
		{{-- <a class="list-group-item  {{$controller == 'set' ? 'list-group-item-success':''}}" href="{{route('set.index')}}">Sets</a> --}}
		
	</div>
</div>







		