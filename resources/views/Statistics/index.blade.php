@extends('layouts.main')

@section('header-title', 'Statistics')

@section('main')
    
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #FFFAFA;
}
tr:nth-child(odd) {
  background-color: #ADD8E6;
}

h1 {
    color: #dddddd;
    font-size: 2em; /* tamanho */
    text-align: center;
}

.centered {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.button {
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid #04AA6D;
}

.button1:hover {
  background-color: #04AA6D;
  color: white;
}
</style>

<h1> Bilhetes vendidos por sessão </h1>
<!-- botao para exportar para excel -->
<div class="button-container">
    <a href="{{ route('export.screenings') }}" class="button button1">Exportar sessões para Excel</a>
</div>

<!-- tabela dos bilhetes vendidos por sessão -->
    <table>
    
  <tr>
    <th>Filme</th>
    <th>Dia da Sessão</th>
    <th>Hora da Sessão</th>
    <th>Teatro</th>
    <th>Bilhetes Vendidos</th>
  </tr>
  @foreach ($screenings as $screening)
  <tr>
    <td>{{ $screening->movie->title }}</td>
    <td>{{ $screening->date }}</td>
    <td>{{ $screening->start_time }}</td>
    <td>{{ $screening->theater->name }}</td>
    <td>{{ $screening->tickets_sold_count }}</td>
  @endforeach
</table>

<br>
</br>

  <h1> Outras estatisticas</h1>

<br>
</br>

  <!-- botao para exportar para excel -->
<div class="button-container">
    <a href="{{ route('export.total_tickets') }}" class="button button1">Exportar total de bilhetes vendidos para Excel</a>
</div>


  <!-- grafico de barras -->
<div class="centered">
  <div id="ticketsByHourPlot" style="width:100%;max-width:700px;"></div>
</div>

<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hours = @json($totalTicketsByHour->pluck('hour'));
        const totalTickets = @json($totalTicketsByHour->pluck('total_tickets'));

        const data = [{
            x: totalTickets,
            y: hours,
            type: 'bar',
            orientation: 'h',
            marker: { color: 'rgba(0,0,255,0.6)' }
        }];

        const layout = {
            title: 'Total de Bilhetes Vendidos por Hora de Sessão',
            xaxis: { title: 'Total de Bilhetes Vendidos' },
            yaxis: { title: 'Hora da Sessão' }
        };

        Plotly.newPlot('ticketsByHourPlot', data, layout);
    });
</script>

<br>
</br>

<!-- botao para exportar para excel -->
<div class="button-container">
    <a href="{{ route('export.payment_types') }}" class="button button1">Exportar tipos de Pagamento para Excel</a>
</div>


  <!-- grafico pie -->
<div class="centered">
  <div id="paymentTypePlot" style="width:100%;max-width:700px;"></div>
</div>

<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
      // Dados para o gráfico de pizza
      const paymentTypes = @json($paymentTypes);
        const labels = paymentTypes.map(pt => pt.payment_type);
        const values = paymentTypes.map(pt => pt.count);

        const pieData = [{
            labels: labels,
            values: values,
            type: 'pie',
            marker: { colors: ['#ff6384', '#36a2eb', '#cc65fe'] }
        }];

        const pieLayout = {
            title: 'Percentagem de Tipos de Pagamento'
        };

        Plotly.newPlot('paymentTypePlot', pieData, pieLayout);
    });
</script>

@endsection