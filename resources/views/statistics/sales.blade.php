@extends('layouts.backoffice')
<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    }

    #chartdiv {
        width: 100%;
        height: 450px;
    }

</style>
@prepend('scripts')
    <!-- Resources -->
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

    <script>

        $(function() {

            /* 날짜 객체 받아서 문자열로 리턴하는 함수 */
            function getDateStr(myDate){

                var day = myDate.getDate();
                var month =  myDate.getMonth() + 1;

                if (String(day).length == 1) {
                    day = "0" + day;
                }

                if (String(month).length == 1) {
                    month = "0" + month;
                }

                return (myDate.getFullYear() + '-' + month + '-' + day)
            }

            /* 오늘 날짜를 문자열로 반환 */
            function today() {
                var d = new Date()
                return getDateStr(d)
            }

            /* 오늘로부터 1주일전 날짜 반환 */
            function lastWeek() {
                var d = new Date()
                var dayOfMonth = d.getDate()
                d.setDate(dayOfMonth - 7)
                return getDateStr(d)
            }

            /* 오늘로부터 1개월전 날짜 반환 */
            function lastMonth() {
                var d = new Date()
                var monthOfYear = d.getMonth()
                d.setMonth(monthOfYear - 1)
                return getDateStr(d)
            }

            $("#today").click(function(){
                $(".sch2").val(today())
                $(".sch1").val(today())
            });

            $("#lastWeek").click(function(){
                $(".sch2").val(today())
                $(".sch1").val(lastWeek())
            });

            $("#lastMonth").click(function(){
                $(".sch2").val(today())
                $(".sch1").val(lastMonth())
            });

            // $(".srch_area :radio").click(function(){
            //     var rname = $(this).attr("name")
            //     $("#search_end_date").val(today())
            //     if( rname == "today"){
            //         $("#search_start_date").val(today())
            //     }else if(rname == "week") {
            //         $("#search_start_date").val(lastWeek())
            //     }else{
            //         $("#search_start_date").val(lastMonth())
            //     }
            // })


            $(".sch1, .sch2").datepicker({
                dateFormat: 'yy-mm-dd', //Input Display Format 변경
                showOtherMonths: true, //빈 공간에 현재월의 앞뒤월의 날짜를 표시
                showMonthAfterYear:true, //년도 먼저 나오고, 뒤에 월 표시
                changeYear: true, //콤보박스에서 년 선택 가능
                changeMonth: true, //콤보박스에서 월 선택 가능
                buttonImageOnly: true, //기본 버튼의 회색 부분을 없애고, 이미지만 보이게 함
                buttonText: "선택", //버튼에 마우스 갖다 댔을 때 표시되는 텍스트
                yearSuffix: "년", //달력의 년도 부분 뒤에 붙는 텍스트
                monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'], //달력의 월 부분 텍스트
                monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'], //달력의 월 부분 Tooltip 텍스트
                dayNamesMin: ['일','월','화','수','목','금','토'], //달력의 요일 부분 텍스트
                dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'], //달력의 요일 부분 Tooltip 텍스트
            });

            $(".sch1").datepicker();
            $(".sch1").datepicker("option", "maxDate", $(".sch2").val());
            $(".sch1").datepicker("option", "onClose", function ( selectedDate ) {
                $(".sch2").datepicker( "option", "minDate", selectedDate );
            });

            $(".sch2").datepicker();
            $(".sch2").datepicker("option", "minDate", $(".sch1").val());
            $(".sch2").datepicker("option", "onClose", function ( selectedDate ) {
                $(".sch1").datepicker( "option", "maxDate", selectedDate );
            });


        });
        /**
         * ---------------------------------------
         * This demo was created using amCharts 4.
         *
         * For more information visit:
         * https://www.amcharts.com/
         *
         * Documentation is available at:
         * https://www.amcharts.com/docs/v4/
         * ---------------------------------------
         */


        // Source data
        var data = @json($data);

        // Create chart instance
        var chart = am4core.create("chartdiv", am4charts.XYChart);

        // Add data
        chart.data = data;

        // Add data pre-processor
        chart.events.on("beforedatavalidated", function(ev) {
            var source = ev.target.data;
            var dates = {};
            var data = [];
            for(var i = 0; i < source.length; i++) {
                var row = source[i];
                if (dates[row.date] == undefined) {
                    dates[row.date] = {
                        date: row.date
                    };
                    data.push(dates[row.date]);
                }
                dates[row.date][source[i].device] = row.value;
            }
            chart.data = data;
        });

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.grid.template.location = 0;
        dateAxis.renderer.minGridDistance = 30;
        // Set date label formatting
        dateAxis.skipEmptyPeriods = true;
        dateAxis.dateFormats.setKey("day", "yyyy-MM-dd");

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        function createSeries(field, name) {
            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = field;
            series.dataFields.dateX = "date";
            series.name = name;
            series.tooltipText = "{dateX}: [b]{valueY}[/]";
            series.strokeWidth = 2;

            var bullet = series.bullets.push(new am4charts.CircleBullet());
            bullet.circle.stroke = am4core.color("#fff");
            bullet.circle.strokeWidth = 2;

            return series;
        }
        createSeries("dev1", "매출");

        chart.legend = new am4charts.Legend();
        chart.cursor = new am4charts.XYCursor();
    </script>
@endprepend

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>매출 통계
                        </div>
                        <div class="card-body">
                            <div class="float-right" >
                                &nbsp;
                            </div>

                            <div class="row">

                                <div class="col-6">
                                    <div class="c-callout c-callout-info"><small class="text-muted">총 매출 금액</small>
                                        <div class="text-value-lg">{{ number_format($total_price) }}</div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="c-callout c-callout-danger"><small class="text-muted">총 데이터 수</small>
                                        <div class="text-value-lg">{{ number_format($total_count) }}</div>
                                    </div>
                                </div>


                            </div>

                            <div id="chartdiv"></div>
                        </div>


                        <div class="card-body table-responsive" >
                            <table class="table  table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>날짜</th>
                                        @foreach($data_table as $data_tables)
                                            <th>
                                            {{ $data_tables['date'] }}
                                            </th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>금액</td>
                                        @foreach($data_table as $data_tables)
                                            <td>
                                                {{ number_format($data_tables['price_value']) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>데이터</td>
                                        @foreach($data_table as $data_tables)
                                            <td>
                                                {{ number_format($data_tables['price_count']) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </thead>
                            </table>
                        </div>


                        <div class="card-body">
                            <div class="col-sm-4 " style="margin: auto">

                                <form class="form-horizontal" action="{{ route($route_name) }}" method="GET">
                                    <input type="hidden" name="sch_key" value="created_at">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="input-group">

                                                <button class="btn-info" type="button" id="today">오늘</button>&nbsp;
                                                <button class="btn-info" type="button" id="lastWeek">일주일</button>&nbsp;
                                                <button class="btn-info" type="button" id="lastMonth">한달</button>&nbsp;
                                                &nbsp;&nbsp;&nbsp;
                                                <input class="form-control sch1" id="input1-group1" type="text" name="sch1" value="{{ $sch1 }}" placeholder="검색어" autocomplete="sch"  >
                                                &nbsp;<span id="input_span" style="display: {{ ($sch_key=="buy_date") ? "block;" : "none;"  }}">~</span>&nbsp;
                                                <input class="form-control sch2" id="input2-group2" type="text" name="sch2" value="{{ $sch2 }}" placeholder="검색어" autocomplete="sch" >
                                                <span class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">검색</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
