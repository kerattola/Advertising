am4core.useTheme(am4themes_animated);

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Set up data source
chart.dataSource.url = "graph_data.csv";
chart.dataSource.parser = new am4core.CSVParser();
chart.dataSource.parser.options.useColumnNames = true;

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "x";

categoryAxis.title.text = 'Timeline';
categoryAxis.renderer.minGridDistance = 40;

// Create value axis
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = 'People';

// Create series
var series1 = chart.series.push(new am4charts.LineSeries());
series1.dataFields.valueY = "y1";
series1.dataFields.categoryX = "x";
series1.name = "x1";
series1.strokeWidth = 3;
series1.tooltipText = "x: {categoryX} / y: {valueY}";

var series2 = chart.series.push(new am4charts.LineSeries());
series2.dataFields.valueY = "y2";
series2.dataFields.categoryX = "x";
series2.name = "x2";
series2.strokeWidth = 3;
series2.tooltipText = "x: {categoryX} / y: {valueY}";

// Scrollbars
chart.scrollbarX = new am4core.Scrollbar();
chart.scrollbarY = new am4core.Scrollbar();

// Add cursor and series tooltip support
chart.cursor = new am4charts.XYCursor();

valueAxis.getSeriesDataItem = function (series, position) {
    var key = this.axisFieldName + this.axisLetter;
    var value = this.positionToValue(position);
    const dataItem = series.dataItems.getIndex(series.dataItems.findClosestIndex(value, function (x) {
        return x[key] ? x[key] : undefined;
    }, "any"));
    return dataItem;
}


function showGraph() {
    document.getElementById('form_graph').style.visibility = "visible";
}
function showResult() {
    document.getElementById('result').style.display = "block";
}

