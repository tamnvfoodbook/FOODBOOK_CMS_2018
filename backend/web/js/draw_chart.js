/**
 * Created by Administrator on 9/19/2015.
 */

/*Pie chart*/
function drawChart_pie(arr,div_id) {
    FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'doughnut2d',
            renderAt: div_id,
            width: '100%',
            //height: '220',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    //"caption": "Split of revenue by product categories",
                    //"subCaption": "Last year",
                    //"numberPrefix": "$",
                    "startingAngle": "20",
                    "showPercentValues": "1",
                    "showPercentInTooltip": "0",
                    "enableSmartLabels": "1",
                    "enableMultiSlicing": "0",
                    "decimals": "1",
                    //Theme
                    "theme": "fint"
                },
                "data": arr
            }
        }).render();

    });
}
/*End pie Chart*/

/*Pie chart*/
function drawChart_columCRMTotal(arr,div_id) {
    FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'column2d',
            renderAt: div_id,
            width: '100%',
            height: '110',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": false,
                    "subcaption": false,
                    "numberPrefix": "+ ",
                    "paletteColors": "#0075c2",
                    "bgColor": "#ffffff",
                    "showBorder": "0",
                    "showCanvasBorder": "0",
                    "usePlotGradientColor": "0",
                    "plotBorderAlpha": "10",
                    "placeValuesInside": "1",
                    "valueFontColor": "#ffffff",
                    "showAxisLines": "1",
                    "axisLineAlpha": "25",
                    "divLineAlpha": "10",
                    "alignCaptionWithCanvas": "0",
                    "showAlternateVGridColor": "0",
                    "captionFontSize": "14",
                    "subcaptionFontSize": "14",
                    "subcaptionFontBold": "0",
                    "toolTipColor": "#ffffff",
                    "toolTipBorderThickness": "0",
                    "toolTipBgColor": "#000000",
                    "toolTipBgAlpha": "80",
                    "toolTipBorderRadius": "2",
                    "toolTipPadding": "5",
                    "height": "500px"
                },
                "data": arr
            }
        }).render();

    });
}
/*End pie Chart*/
/*Pie chart*/
function drawChart_columCRM(arr,div_id) {
    FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'column2d',
            renderAt: div_id,
            width: '100%',
            height: '110',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": false,
                    "subcaption": false,
                    //"numberPrefix": "+ ",
                    "paletteColors": "#0075c2",
                    "bgColor": "#ffffff",
                    "showBorder": "0",
                    "showCanvasBorder": "0",
                    "usePlotGradientColor": "0",
                    "plotBorderAlpha": "10",
                    "placeValuesInside": "1",
                    "valueFontColor": "#ffffff",
                    "showAxisLines": "1",
                    "axisLineAlpha": "25",
                    "divLineAlpha": "10",
                    "alignCaptionWithCanvas": "0",
                    "showAlternateVGridColor": "0",
                    "captionFontSize": "14",
                    "subcaptionFontSize": "14",
                    "subcaptionFontBold": "0",
                    "toolTipColor": "#ffffff",
                    "toolTipBorderThickness": "0",
                    "toolTipBgColor": "#000000",
                    "toolTipBgAlpha": "80",
                    "toolTipBorderRadius": "2",
                    "toolTipPadding": "5",
                    "height": "500px"
                },
                "data": arr
            }
        }).render();

    });
}
/*End pie Chart*/

/*Pie chart*/
function drawChart_columCRMNgang(arr,div_id) {
    FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'bar2d',
            renderAt: div_id,
            width: '100%',
            height: '110',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": false,
                    "subcaption": false,
                    //"numberPrefix": "+ ",
                    "palettecolors": "#0075c2,#F6BD0F,#8BBA00,#A66EDD,#F984A1",
                    "bgColor": "#ffffff",
                    "showBorder": "0",
                    "showCanvasBorder": "0",
                    "usePlotGradientColor": "0",
                    "plotBorderAlpha": "10",
                    "placeValuesInside": "1",
                    "valueFontColor": "#000000",
                    "showAxisLines": "1",
                    "axisLineAlpha": "25",
                    "divLineAlpha": "10",
                    "alignCaptionWithCanvas": "0",
                    "showAlternateVGridColor": "0",
                    "captionFontSize": "14",
                    "subcaptionFontSize": "14",
                    "subcaptionFontBold": "0",
                    "toolTipColor": "#ffffff",
                    "toolTipBorderThickness": "0",
                    "toolTipBgColor": "#000000",
                    "toolTipBgAlpha": "80",
                    "toolTipBorderRadius": "2",
                    "toolTipPadding": "5",
                    "height": "500px"
                },
                "data": arr
            }
        }).render();

    });
}
/*End pie Chart*/

/*Pie chart*/
function drawChart_pietansuatCRM(arr,div_id) {
    FusionCharts.ready(function () {
        var revenueChart = new FusionCharts({
            type: 'doughnut2d',
            renderAt: div_id,
            width: '100%',
            height: '110',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "numberPrefix": "$",
                    "showBorder": "0",
                    "use3DLighting": "0",
                    "enableSmartLabels": "0",
                    "startingAngle": "310",
                    "showLabels": "0",
                    "showPercentValues": "1",
                    "showLegend": "1",
                    "defaultCenterLabel": "Total revenue: $64.08K",
                    "centerLabel": "Revenue from $label: $value",
                    "centerLabelBold": "1",
                    "showTooltip": "0",
                    "decimals": "0",
                    "useDataPlotColorForLabels": "1",
                    "theme": "fint"
                },
                "data": [
                    {
                        "label": "Food",
                        "value": "28504"
                    },
                    {
                        "label": "Apparels",
                        "value": "14633"
                    }
                ]
            }
        }).render();

    });
}
/*End pie Chart*/


function loadChart(arr,day,name,div_id){
    FusionCharts.ready(function () {
        var vstrChart = new FusionCharts({
            type: 'msline',
            renderAt: div_id,
            width: '100%',
            //height: '220',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": " ",
                    //"subcaption": " ",
                    //"xaxisname": "Thống kê 7 ngày",
                    //"yaxisname": "Degree  (in Fahrenheit)",
                    "palette": "3",
                    "bgcolor": "FFFFFF",
                    "canvasbgcolor": "66D6FF",
                    "canvasbgalpha": "5",
                    "canvasborderthickness": "1",
                    "canvasborderalpha": "20",
                    "legendshadow": "0",
                    "numbersuffix": "",
                    "showvalues": "1",
                    "alternatehgridcolor": "ffffff",
                    "alternatehgridalpha": "100",
                    "showborder": "0",
                    "legendborderalpha": "0",
                    "legendiconscale": "1.5",
                    "divlineisdashed": "1"
                },
                "categories": [
                    {
                        "category": day
                    }
                ],
                "dataset": [
                    {
                        "seriesname": name,
                        "color": "00a65a",
                        "data": arr
                    }
                ],
                "styles": {
                    "definition": [
                        {
                            "name": "captionFont",
                            "type": "font",
                            "size": "15"
                        }
                    ],
                    "application": [
                        {
                            "toobject": "caption",
                            "styles": "captionfont"
                        }
                    ]
                }
            }
        }).render();
    });
}


function loadChartTrafic(arr1,arr2,day,div_id){
    FusionCharts.ready(function () {
        var vstrChart = new FusionCharts({
            type: 'msline',
            renderAt: div_id,
            width: '100%',
            //height: '100%',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": " ",
                    //"subcaption": " ",
                    //"xaxisname": "Thống kê 7 ngày",
                    //"yaxisname": "Degree  (in Fahrenheit)",
                    "palette": "3",
                    "bgcolor": "FFFFFF",
                    "canvasbgcolor": "66D6FF",
                    "canvasbgalpha": "5",
                    "canvasborderthickness": "1",
                    "canvasborderalpha": "20",
                    "legendshadow": "0",
                    "numbersuffix": "",
                    "showvalues": "1",
                    "alternatehgridcolor": "ffffff",
                    "alternatehgridalpha": "100",
                    "showborder": "0",
                    "legendborderalpha": "0",
                    "legendiconscale": "1.5",
                    "divlineisdashed": "1"
                },
                "categories": [
                    {
                        "category": day
                    }
                ],
                "dataset": [
                    {
                        "seriesname": "Đơn hàng hủy",
                        "color": "e61a05",
                        "data": arr1
                    },
                    {
                        "seriesname": "Đơn hàng thành công",
                        "color": "00a65a",
                        "data": arr2
                    }
                ],
                "styles": {
                    "definition": [
                        {
                            "name": "captionFont",
                            "type": "font",
                            "size": "15"
                        }
                    ],
                    "application": [
                        {
                            "toobject": "caption",
                            "styles": "captionfont"
                        }
                    ]
                }
            }
        }).render();
    });
}



function loadChartTop(arr,day,div_id){
    FusionCharts.ready(function () {
        var vstrChart = new FusionCharts({
            type: 'msline',
            renderAt: div_id,
            width: '100%',
            //height: '100%',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": " ",
                    //"subcaption": " ",
                    //"xaxisname": "Thống kê 7 ngày",
                    //"yaxisname": "Degree  (in Fahrenheit)",
                    "palette": "3",
                    "bgcolor": "FFFFFF",
                    "canvasbgcolor": "66D6FF",
                    "canvasbgalpha": "5",
                    "canvasborderthickness": "1",
                    "canvasborderalpha": "20",
                    "legendshadow": "0",
                    "numbersuffix": "",
                    "showvalues": "1",
                    "alternatehgridcolor": "ffffff",
                    "alternatehgridalpha": "100",
                    "showborder": "0",
                    "legendborderalpha": "0",
                    "legendiconscale": "1.5",
                    "divlineisdashed": "1"
                },
                "categories": [
                    {
                        "category": day
                    }
                ],
                "dataset": arr,
                "styles": {
                    "definition": [
                        {
                            "name": "captionFont",
                            "type": "font",
                            "size": "15"
                        }
                    ],
                    "application": [
                        {
                            "toobject": "caption",
                            "styles": "captionfont"
                        }
                    ]
                }
            }
        }).render();
    });
}