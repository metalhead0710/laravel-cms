
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

    <script type="text/javascript" src="{{ asset('assets/components/chart.js/Chart.js') }}"></script>
    <script src="{{ asset('assets/js/pages/admin/home/analytics.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      App.Page.Analytics({
        colors: ['#4ECBDF', '#3EB7B0', '#26A7E0', '#42C1FC', '#2F85C0', '#FD6060', '#486860', '#6AC239'],
        browsers: {!! $topBrowsers !!},
        countries: {!! $countries !!},
        pageViews: {!! $pageViews !!},
        topRefferers: {!! $topRefferers !!},
        users: {!! $users !!},
      });
    </script>
