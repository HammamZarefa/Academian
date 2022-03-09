@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container page-container">
   <div class="row">
      <div class="col-md-12">
         <h4>Dashboard</h4>
         <hr>
      </div>
   </div>
   <div class="row">
      <div class="col-md-3">
         <div class="card card-bg-indigo">
            <div class="card-body">
               <h5 class="card-title">New Customers </h5>               
               <h5 class="float-right">
                  <i class="fas fa-spinner fa-spin"></i> 
                  <span id="users_count"></span>
               </h5>
               <p>Last 7 days</p>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card card-bg-indigo-light">
            <div class="card-body">
               <h5 class="card-title">Orders </h5>               
               <h5 class="float-right">
                  <i class="fas fa-spinner fa-spin"></i> 
                  <span id="orders_count"></span>
               </h5>
               <p>In progress</p>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card card-bg-red-light">
            <div class="card-body">
               <h5 class="card-title">Bill Paid</h5>
               <h5 class="float-right">
                  <i class="fas fa-spinner fa-spin"></i> 
                  <span id="paid_bills_amount"></span>
               </h5>
               <p>Last 30 days</p>
            </div>
         </div>
      </div>
      <div class="col-md-3">
         <div class="card card-bg-green">
            <div class="card-body">
               <h5 class="card-title">Profit</h5>
               <h5 class="float-right">
                  <i class="fas fa-spinner fa-spin"></i> 
                  <span id="profit_amount"></span>
               </h5>
               <p>Last 30 days</p>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-8">
         <canvas id="canvas"></canvas>
      </div>
      <div class="col-md-4">
         <div class="">
            <div class="">
               <h5 class="card-title">Activity Log</h5>
               <small>Most recent 5 activities <a href="{{ route('activity_log') }}">See All</a></small>
               @if($data['activities']->count() > 0)
                @foreach($data['activities'] as $activity)
                    @isset($activity->causer->id)
                    <p class="media">
                        <div class="media-body">
                        <a href="{{ route('user_profile', $activity->causer->id) }}">{{ $activity->causer->full_name }}</a> has
                        {!! $activity->description !!}
                        </div>
                        <small class="text-muted">
                            {{ $activity->created_at->format("d-M-Y H:i")  }}
                        </small>
                    </p>
                    @endisset
                @endforeach
               @else
                No activity
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')

<script>

   window.chartColors = {
   red: 'rgb(255, 99, 132)',
   orange: 'rgb(255, 159, 64)',
   yellow: 'rgb(255, 205, 86)',
   green: 'rgb(75, 192, 192)',
   blue: 'rgb(54, 162, 235)',
   purple: 'rgb(153, 102, 255)',
   grey: 'rgb(201, 203, 207)'
};

// DEPRECATED
   window.randomScalingFactor = function() {
      return Math.floor(Math.random() * 100) + 20;
   };
      var formatted_values = [];
     
      var config = {
         type: 'line',
         data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
               label: 'Income',
               backgroundColor: window.chartColors.red,
               borderColor: window.chartColors.red,
               // backgroundColor: window.chartColors.blue,
               // borderColor: window.chartColors.blue,
               data: [
                  randomScalingFactor(),
                  randomScalingFactor(),
                  randomScalingFactor(),
                  randomScalingFactor(),
                  randomScalingFactor(),
                  randomScalingFactor(),
                  randomScalingFactor()
               ],
               fill: false,
            }]
         },
         options: {
            responsive: true,
            title: {
               display: true,
               text: 'Last 5 months'
            },
            tooltips: {
               mode: 'index',
               intersect: false,
            },
            hover: {
               mode: 'nearest',
               intersect: true
            },
            scales: {
               xAxes: [{
                  display: true,
                  scaleLabel: {
                     display: true,
                     labelString: 'Month'
                  }
               }],
               yAxes: [{
                  display: true,
                  scaleLabel: {
                     display: true,
                     labelString: 'Profit'
                  },
                  ticks: {
                    callback: function(label, index, labels) {
                        return accounting.formatNumber(label, currencyConfig.number);
                    }
                  }
               }]
            },
            tooltips: {
             callbacks: {
               label: function (tooltipItem, data) {
                 var label = data.datasets[tooltipItem.datasetIndex].label || ''

                 if (label) {
                   label += ': '
                 }    
                 label += accounting.formatMoney(tooltipItem.yLabel, currencyConfig.currency);
                 return label
               },
             },
           }
         }
      };

      window.onload = function() {         

         $.post( "{{ route('income_graph') }}", {
              '_token': $('meta[name=csrf-token]').attr('content'),              
          })
         .done(function(response) {
            config.data.labels = response.labels;
            config.data.datasets[0]['data'] = response.values;
            formatted_values = response.formatted_values; 
          
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myLine = new Chart(ctx, config);         
         })
         .fail(function() {
             console.log( "error loading the chart" );
         });   
         
      };


      $(function(){

         fetch({name : 'users_count', 'elementId': 'users_count'});
         fetch({name : 'orders_count', 'elementId': 'orders_count'});
         fetch({name : 'paid_bills_amount', 'elementId': 'paid_bills_amount'});
         fetch({name : 'profit_amount', 'elementId': 'profit_amount'});


      });

      function fetch(query)
      {
        $.post( "{{ route('dashboard_statistics') }}", {
              '_token': "{{ csrf_token() }}",              
              'name': query.name
          })
         .done(function(response) {            
            $('#' + query.elementId).html(response).prev('.fa-spinner').hide();         
         })
         .fail(function() {
     
         });   
      }

   </script>
@endpush