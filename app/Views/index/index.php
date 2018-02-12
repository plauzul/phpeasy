@section("title")PHPEasy@endsection

@section("insertCss")
	{{{ $this->insertCss("index/index.css") }}}
@endsection

@section("body")
	<div class="wrapper">
		<div class="block container">
			<p>PHPEasy o framework php rápido leve e robusto.</p>
			<div class="row">
				<md-button class="md-raised md-primary" ng-click="goTo('https://github.com/plauzul/ng2-izitoast')">documentação</md-button>
				<md-button class="md-raised md-primary" ng-click="goTo('https://github.com/plauzul/ng2-izitoast')">contribua</md-button>
			</div>
		</div>
	</div>
@endsection

@section("insertJs")
	{{{ $this->insertJs("index/index.js") }}}
@endsection