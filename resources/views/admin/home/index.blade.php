@extends('layouts.backend.default')
@section('title', 'Статистика')
@section('Stylesheets')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .chart-container{
        background-color: #ccc;
        margin: 5px;
        padding: 5px;
    }
</style>
@endsection
@section('content')
<div class="page-header">
	<h1>Статистика відвідувань сайту
		<small>тут можна переглянути статистику</small>
	</h1>
</div>
@include('layouts._partials.feedback')
<section class="content">
    <div class="actions pull-right mg-bt-15">
        <form method="post" action="{{ route('admin.home') }}" id="period_form" class="form-inline">
            {{ csrf_field()}}
            <div class="form-group">
                <label for="period"  class="control-label">Виберіть початок періоду</label>
                <!--<select class="form-control" name="period" id="period">
                    <option value="day" {{ $period === 'day' ? 'selected' : ''}}>Сьогодні</option>
                    <option value="week" {{ $period === 'week' ? 'selected' : ''}} >Цього тижня</option>
                    <option value="month" {{ $period === 'month' ? 'selected' : ''}}>Цього місяця</option>
                    <option value="year" {{ $period === 'year' ? 'selected' : ''}} >Протягом року</option>
                </select>-->
                <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="period" id="period" class="form-control" value="{{ $period}}">
                </div>
            </div>
        </form>
    </div>
	<div class="clearfix"></div>
    @if(isset($popPages))
    <h3>Найпопулярніші сторінки</h3>
    <table class="table">
        <tr>
            <th>Сторінка</th>
            <th>Url</th>
            <th>Переглядів</th>
        </tr>
        @foreach($popPages as $page)
        <tr>
            <td>{{ $page['pageTitle'] }}</td>
            <td>{{ $page['url'] }}</td>
            <td>{{ $page['pageViews'] }}</td>
        </tr>
        @endforeach
    </table>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="chart-container">
                <h4>Відвідувачі</h4>
                <canvas id="visitors" width="400" height="300"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container">
                <h4>Джерела трафіку</h4>
                <canvas id="refferers" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="chart-container">
                <h4>Браузери</h4>
                <canvas id="pie" width="400" height="300"></canvas>
            </div>
        </div>
		<div class="col-md-4">
            <div class="chart-container">
                <h4>Країни</h4>
                <canvas id="countries" width="400" height="300"></canvas>
            </div>
        </div>
		<div class="col-md-4">
            <div class="chart-container">
                <h4>Повторне відвідування сайту</h4>
                <canvas id="users" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
</section>
@stop
@section('Scripts')
<script type="text/javascript" src="{{ asset('assets/components/chart.js/Chart.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.uk.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('#period').on("change", function () {
            $('#period_form').submit();
        });
        $('.date').datepicker({
            autoclose:true,
            language: 'uk'
        });
    });
	function getRandomColor() {
	  var letters = '0123456789ABCDEF';
	  var color = '#';
	  for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	  }
	  return color;
	}
	
	var colors = ['#4ECBDF', '#3EB7B0', '#26A7E0', '#42C1FC', '#2F85C0', '#FD6060', '#486860', '#6AC239'];
	
    var browsers = {!! $topBrowsers !!};
    var countries = {!! $countries !!};
    var pageViews = {!! $pageViews !!};
    var topRefferers = {!! $topRefferers !!};
    var users = {!! $users !!};

	var setColors = function(array)
    {
        for(i = 0; i < array.length; i++){
            array[i].color = colors[i];
        }
    }
    setColors(browsers);
    setColors(topRefferers);
    setColors(users);
    var ctxRefferers = document.getElementById('refferers').getContext('2d');
    var configRefferers = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: topRefferers.map(function(topRefferers) {
                    return topRefferers.pageViews;
                }),
                backgroundColor: topRefferers.map(function(topRefferers) {
                    return topRefferers.color;
                })
            }],
            labels: topRefferers.map(function(topRefferers) {
                return topRefferers.url;
            })
        },
        options: {
            responsive: true
        }
    };
	var ctxBrowsers = document.getElementById('pie').getContext('2d');
	var configBrowsers = {
		type: 'pie',
		data: {
			datasets: [{
				data: browsers.map(function(browsers) {
						return browsers.sessions;
					}),
				backgroundColor: browsers.map(function(browsers) {
						return browsers.color;
					})
			}],
			labels: browsers.map(function(browsers) {
						return browsers.browser;
					})
		},
		options: {
			responsive: true
		}
	};
	
	var ctxCountries = document.getElementById('countries').getContext('2d');
	var configCountries = {
		type: 'pie',
		data: {
			datasets: [{
				data: countries.map(function(countries) {
						return parseInt(countries[1]);
					}),
				backgroundColor: countries.map(function(countries) {
						return getRandomColor();
					})
			}],
			labels: countries.map(function(countries) {
						return countries[0];
					})
		},
		options: {
			responsive: true
		}
	};

    var ctxVisitors = document.getElementById('visitors').getContext('2d');
    var configVisitors = {
        type: 'bar',
        data: {
            datasets: [{
                        label: 'Кількість користувачів',
                        data: pageViews.map(function(pageViews) {
                            return pageViews.visitors;
                        }),
                        backgroundColor: '#FF9EB3',
                        borderColor: '#FF6384',
                        borderWidth: 1
                    },{
                        label: 'Кількість переглядів',
                        data: pageViews.map(function(pageViews) {
                            return pageViews.pageViews;
                        }),
                        backgroundColor: '#82CDFF',
                        borderColor: '#36A2EB',
                        borderWidth: 1
                    }
            ],
            labels: pageViews.map(function(pageViews) {
                var date = new Date(pageViews.date.date);
                var options = {
                    year: "numeric", month: "short",
                    day: "numeric"
                }
                return date.toLocaleDateString("uk-UK", options);
            })
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    };

    var ctxUsers = document.getElementById('users').getContext('2d');
    var configUsers = {
        type: 'horizontalBar',
        data: {
            datasets: [{
                label: 'Одиночні візити',
                data: users.map(function(users) {
                    return parseInt(users[1]);
                }),
                backgroundColor: users.map(function(users) {
                    return users.color;
                    }),
                borderWidth: 1
            }],
            labels: ['Одиночні', 'Повторні']
        },
        options: {
            tooltips: {
                enabled: false
            },
            responsive: true,
            legend: false,
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    };
	
	var pie = new Chart(ctxBrowsers, configBrowsers);
	var countiesPie = new Chart(ctxCountries, configCountries);
    var pageViews = new Chart(ctxVisitors, configVisitors);
    var referers = new Chart(ctxRefferers, configRefferers);
    var usr = new Chart(ctxUsers, configUsers);

</script>
@endsection