var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}
    // This will get the first returned node in the jQuery collection.
    $.ajax({
      url:"ajax/grafico.ajax.php",
      method: "POST",
      dataType: "json",
      success: function (data) {
        if(data!=false)
        {
            var vendedores =[];
            var meses=[];
            var sets=[];
            for (var i = 0; i < data.length; i++) {
                var asesor=data[i]['asesor'];
                console.log(asesor);
                if(!vendedores.includes(asesor)){
                  vendedores.push(asesor);
                  meses.push([0,0,0,0,0,0,0,0,0,0,0,0]);
                  var ind = meses.length-1;
                  meses[ind][parseInt(data[i]['mes'])-1] = parseInt(data[i]['rep']);
                }
                else{
                  var inde = vendedores.indexOf(asesor);
                  meses[inde][parseInt(data[i]['mes'])-1] = parseInt(data[i]['rep']); 
                }
            }
            for (var i = 0; i < vendedores.length; i++) {
              var ran1 = getRandomInt(0,256);
              var ran2 = getRandomInt(0,256);
              var ran3 = getRandomInt(0,256); 
              var mensaje = '{"label": "'+vendedores[i]+'","fillColor": "rgba('+ran1+', '+ran2+', '+ran3+', 1)","strokeColor": "rgba('+ran1+', '+ran2+', '+ran3+', 1)","pointColor": "rgba('+ran1+', '+ran2+', '+ran3+', 1)","pointStrokeColor": "#c1c7d1","pointHighlightFill": "#fff","pointHighlightStroke": "rgba(220,220,220,1)","data": ['+meses[i].toString()+']}';
              sets.push(JSON.parse(mensaje));
            }
            var areaChart       = new Chart(areaChartCanvas)

            var areaChartData = {
              labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
              datasets: sets,
              
            }

            var areaChartOptions = {
              //Boolean - If we should show the scale at all
              showScale               : true,
              //Boolean - Whether grid lines are shown across the chart
              scaleShowGridLines      : false,
              //String - Colour of the grid lines
              scaleGridLineColor      : 'rgba(0,0,0,.05)',
              //Number - Width of the grid lines
              scaleGridLineWidth      : 1,
              //Boolean - Whether to show horizontal lines (except X axis)
              scaleShowHorizontalLines: true,
              //Boolean - Whether to show vertical lines (except Y axis)
              scaleShowVerticalLines  : true,
              //Boolean - Whether the line is curved between points
              bezierCurve             : true,
              //Number - Tension of the bezier curve between points
              bezierCurveTension      : 0.3,
              //Boolean - Whether to show a dot for each point
              pointDot                : false,
              //Number - Radius of each point dot in pixels
              pointDotRadius          : 4,
              //Number - Pixel width of point dot stroke
              pointDotStrokeWidth     : 1,
              //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
              pointHitDetectionRadius : 20,
              //Boolean - Whether to show a stroke for datasets
              datasetStroke           : true,
              //Number - Pixel width of dataset stroke
              datasetStrokeWidth      : 2,
              //Boolean - Whether to fill the dataset with a color
              datasetFill             : true,
              //String - A legend template
              legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
              //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
              maintainAspectRatio     : true,
              //Boolean - whether to make the chart responsive to window resizing
              responsive              : true
            }

            //Create the line chart
            areaChart.Line(areaChartData, areaChartOptions)            
        }
        // body...
      }
    });
    