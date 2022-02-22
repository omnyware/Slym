google.load("visualization", "1", {packages:["corechart"]});


$(function(){

  let js = $('#somaContas').val();
  js = JSON.parse(js);
      //montando o array com os dados
      let indices = [''];
      let valores = [''];
      let p = [];
      $.each( js, function( key, value ) {
        indices.push(key);
        valores.push(parseInt(value));
      });
      p.push(['Categoria', 'Valor'])
      $.each( js, function( key, value ) {

        p.push([key, parseInt(value)])
      });

      console.log(p)
      var data = google.visualization.arrayToDataTable([
        indices, valores
        ]);
      var dataPizza = google.visualization.arrayToDataTable(
        p.map(t => {
          return t
        })
        );
        //opçoes para o gráfico barras
        var options = {
          title: 'Barra',
          vAxis: {title: 'Valor',  titleTextStyle: {color: 'green'}},//legenda vertical
          
        };
        //instanciando e desenhando o gráfico barras
        var coluna = new google.visualization.ColumnChart(document.getElementById('coluna'));
        coluna.draw(data, options);
        //opções para o gráfico linhas
        var pizza = new google.visualization.PieChart(document.getElementById('pizza'));
        pizza.draw(dataPizza, {
          title: 'Pizza',
          is3D: true,
        });


      });

$('#ver-graficos').click(() => {
  $('#graficos').removeClass("dismiss");
})

