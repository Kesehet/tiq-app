   <style>
              .add-button {
                  display: inline-block;
                  padding: 20px 10px;
                  background-color: #4CAF50;
                  color: white;
                  text-decoration: none;
                  border-radius: 5px;
              }

              .add-button:hover {
                  background-color: #45a049;
              }
    </style>

  <div class="dashboard-container">

 @yield('content')
 <style>
 .add-button {
     display: inline-block;
     padding: 30px 25px; /* Adjust the padding for desired size */
     font-size: 15px;    /* Adjust the font size for desired size */
     background-color: #4CAF50;
     color: white;
     text-decoration: none;
     border-radius: 10px;
 }


 .add-button:hover {
     background-color: #45a049;
 }
 </style>
 <div class="w3-container">
     <div class="w3-row-padding w3-padding-large">

       <!-- Language Card -->
       <div class="w3-col l3 s12 m3 ">
         <div class="number-card w3-padding w3-feature w3-round-large">
           <h2>{{$languagecount}}</h2>
           <p>Language</p>
         </div>
       </div>

       <!-- Quizzes Card -->
       <div class="w3-col l3 s12 m3 ">
         <div class="number-card w3-padding w3-feature w3-round-large">
           <h2>{{$quizcount}}</h2>
           <p>Number of Quizzes</p>
         </div>
       </div>

       <!-- Questions Card -->
       <div class="w3-col l3 s12 m3 ">
         <div class="number-card w3-padding w3-feature w3-round-large">
           <h2>{{$questioncount}}</h2>
           <p>Number of Questions</p>
         </div>
       </div>


       <!-- Users Card -->
       <div class="w3-col l3 s12 m3 ">
         <div class="number-card w3-padding w3-feature w3-round-large">
           <h2>{{$usercount}}</h2>
           <p>Number of Users</p>
         </div>
       </div>

     </div>
 </div>

 <div class="w3-container">
 <div class="w3-padding w3-col l6 s12 m3 ">
     <h5>Recent Quizzes</h5>
     <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
       <tr>
                   <th> Name </th>
                   <th>Last Modified </th>
               </tr>
       @foreach ($recentQuiz as $quiz)
       <tr>
         <td>{{$quiz->title}} </td>
         <td>{{\Carbon\Carbon::parse($quiz->updated_at)->diffForHumans()}} </td>
       </tr>
       @endforeach
     </table><br>
    <a href="{{ route('dashboard.question.combo') }}" class="w3-button w3-dark-grey">Add Quiz<i class="fa fa-arrow-right"></i></a>

     </div>


     <div class="w3-padding w3-col l6 s12 m6 ">
     <canvas id="myChart" width="400" height="400"></canvas> <!-- Canvas element for the chart -->
      <script>
     var ctx = document.getElementById('myChart').getContext('2d');
     var myChart = new Chart(ctx, {
         type: 'bar',
         data: {
             labels: @json($recentQuizStats["labels"] ?? []),
             datasets: [{
                 label: 'Number of Users who have attempted Quiz',
                 data: @json($recentQuizStats["data"] ?? []),
                 backgroundColor: 'rgba(0, 92, 39, 0.2)',
                 borderColor: 'rgba(0, 92, 39, 1)',
                 borderWidth: 1
             }]
         },
         options: {
             responsive: true,
             animation: {
                 duration: 2000, // Duration in milliseconds
                 delay: (context) => {
                     let delay = 0;
                     if (context.type === 'data' && context.mode === 'default' && !context.dropped) {
                         context.dropped = true;
                         delay = context.dataIndex * 300 + context.datasetIndex * 100;
                     }
                     return delay;
                 }
             }
         }
     });

     </script>
     </div>
     </div>

























