/**
 * Theme: Crovex - Responsive Bootstrap 4 Admin Dashboard
 * Author: Mannatthemes
 * Dashboard Js
 */

  //colunm-1
  
var options = {
  chart: {
      height: 300,
      type: 'bar',
      toolbar: {
          show: false
      },
      dropShadow: {
        enabled: true,
        top: 0,
        left: 5,
        bottom: 5,
        right: 0,
        blur: 5,
        color: '#45404a2e',
        opacity: 0.35
    },
  },
  plotOptions: {
      bar: {
          horizontal: false,
          endingShape: 'rounded',
          columnWidth: '25%',
      },
  },
  dataLabels: {
      enabled: false,
  },
  stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
  },
  colors: ["#2c77f4", "#1ecab8"],
  series: [{
      name: 'New Tickets',
      data: [68, 44, 55, 57, 56, 61, 58, 63, 60, 66] 
  }, {
      name: 'Solved Tickets',
      data: [51, 76, 85, 101, 98, 87, 105, 91, 114, 94]
  },],
  xaxis: {
      categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
      axisBorder: {
        show: true,
      },  
      axisTicks: {
        show: true,
      },    
  },
  legend: {
    offsetY: -10,
  },
  yaxis: {
      title: {
          text: 'Tickets'
      }
  },
  fill: {
      opacity: 1,
  },
  // legend: {
  //     floating: true
  // },
  grid: {
      row: {
          colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.2
      },
      borderColor: '#f1f3fa'
  },
  tooltip: {
      y: {
          formatter: function (val) {
              return "" + val + ""
          }
      }
  }
}

var chart = new ApexCharts(
  document.querySelector("#ana_dash_1"),
  options
);

chart.render();


// saprkline chart


var dash_spark_1 = {
    
  chart: {
      type: 'area',
      height: 60,
      sparkline: {
          enabled: true
      },
      dropShadow: {
        enabled: true,
        top: 12,
        left: 0,
        bottom: 5,
        right: 0,
        blur: 2,
        color: '#45404a2e',
        opacity: 0.1
    },
  },
  stroke: {
      curve: 'smooth',
      width: 3
    },
  fill: {
      opacity: 1,
      gradient: {
        shade: '#2c77f4',
        type: "horizontal",
        shadeIntensity: 0.5,
        inverseColors: true,
        opacityFrom: 0.1,
        opacityTo: 0.1,
        stops: [0, 80, 100],
        colorStops: []
    },
  },
  series: [{
    data: [4, 8, 5, 10, 4, 16, 5, 11, 6, 11, 30, 10, 13, 4, 6, 3, 6]
  }],
  yaxis: {
      min: 0
  },
  colors: ['#2c77f4'],
}
new ApexCharts(document.querySelector("#dash_spark_1"), dash_spark_1).render();


var dash_spark_2 = {
    
  chart: {
      type: 'area',
      height: 60,
      sparkline: {
          enabled: true
      },
      dropShadow: {
        enabled: true,
        top: 12,
        left: 0,
        bottom: 5,
        right: 0,
        blur: 2,
        color: '#45404a2e',
        opacity: 0.1
    },
  },
  stroke: {
      curve: 'smooth',
      width: 3
    },
  fill: {
      opacity: 1,
      gradient: {
        shade: '#fd3c97',
        type: "horizontal",
        shadeIntensity: 0.5,
        inverseColors: true,
        opacityFrom: 0.1,
        opacityTo: 0.1,
        stops: [0, 80, 100],
        colorStops: []
    },
  },
  series: [{
    data: [4, 8, 5, 10, 4, 25, 5, 11, 6, 11, 5, 10, 3, 14, 6, 8, 6]
  }],
  yaxis: {
      min: 0
  },
  colors: ['#fd3c97'],
}
new ApexCharts(document.querySelector("#dash_spark_2"), dash_spark_2).render();



//Device-widget
$(document).ready(function(){ 
  $.ajax({
      type: 'GET',
      url: 'counthome',
      dataType: "json",
      success: function(data){
          if(data){
            var Complete = new Array();
            var Name = new Array();
            for(i=0;i<data.length;i++){
                Complete[i] = data[i].count
                Name[i] = data[i].name
            }
            var options = {
              chart: {
                  height: 280,
                  type: 'donut',
                  dropShadow: {
                    enabled: true,
                    top: 10,
                    left: 0,
                    bottom: 0,
                    right: 0,
                    blur: 2,
                    color: '#45404a2e',
                    opacity: 0.15
                },
              }, 
              plotOptions: {
                pie: {
                  donut: {
                    size: '85%'
                  }
                }
              },
              dataLabels: {
                enabled: false,
              }, 
              stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
              },
              series: Complete,
              legend: {
                  show: false,
                  position: 'bottom',
                  horizontalAlign: 'center',
                  verticalAlign: 'middle',
                  floating: false,
                  fontSize: '14px',
                  offsetX: 0,
                  offsetY: -13
              },
              labels: Name,
              colors: ["#65CDFF",  "#A915ED",  "#51B9FF",  "#1915ED", "#3DA5FF",  "#2991FF", "#1F87F6", "#0041B0","#65CDFF", "#0B73E2", "#0169D8", "#0055C4","#004BBA",  "#0037A6", "#339BFF", "#002D9C","#155AED", "#1536ED","#47AFFF", "#6115ED", "#8515ED","#5BC3FF",],
             
              responsive: [{
                  breakpoint: 600,
                  options: {
                    plotOptions: {
                        donut: {
                          customScale: 0.2
                        }
                      },        
                      chart: {
                          height: 240
                      },
                      legend: {
                          show: false
                      },
                  }
              }],
            
              tooltip: {
                y: {
                    formatter: function (val) {
                        return   val
                    }
                }
              }
              
            }
            
            var chart = new ApexCharts(
              document.querySelector("#ana_device"),
              options
            );
            
            chart.render();

          }
        }
    });
}) 
