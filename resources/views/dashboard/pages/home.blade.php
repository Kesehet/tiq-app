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
       <div class="w3-col l3 s12 m6 ">
         <div class="number-card w3-padding w3-feature w3-round-large">
           <h2>{{$usercount}}</h2>
           <p>Number of Users</p>
         </div>
       </div>

     </div>
 </div>

 <div class="w3-container">
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
    <a href="{{ route('dashboard.question.combo') }}" class="w3-button w3-dark-grey">Add Questions<i class="fa fa-arrow-right"></i></a>

     </div>

























