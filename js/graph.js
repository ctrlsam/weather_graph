function graph(figure){

  var layout = {
    xaxis: {
      fixedrange: true,
      title: 'Date',
      titlefont: {
        family: 'Courier New, monospace',
        size: 18,
        color: '#7f7f7f'
      }
    },
    yaxis: {
      fixedrange: true,
      title: 'Temperature (F)',
      titlefont: {
        family: 'Courier New, monospace',
        size: 18,
        color: '#7f7f7f'
      },
    },
    showlegend: false,
    margin: {
      l: 30,
      r: 0,
      b: 60,
      t: 0,
      pad: 0
    }
  };

  // Resize and Draw
  (function() {
    var d3 = Plotly.d3;

    var WIDTH_IN_PERCENT_OF_PARENT = 100,
        HEIGHT_IN_PERCENT_OF_PARENT = 50;

    var gd3 = d3.select('body .content .col-md-12 #graph')
        .append('div')
        .style({
            width: WIDTH_IN_PERCENT_OF_PARENT + '%',
            'margin-left': (100 - WIDTH_IN_PERCENT_OF_PARENT) / 2 + '%',

            height: HEIGHT_IN_PERCENT_OF_PARENT + 'vh',
            'margin-top': (100 - HEIGHT_IN_PERCENT_OF_PARENT) / 5 + 'vh'
        });

    var gd = gd3.node();

    Plotly.plot(gd, figure.data, layout, {displayModeBar: false});

    window.onresize = function() {
        Plotly.Plots.resize(gd);
    };

    })();
}