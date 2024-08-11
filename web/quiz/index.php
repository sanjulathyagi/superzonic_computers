<?php
session_start();
include '../../config.php';
include '../header.php';
include '../../function.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let questions = [];
    let currentQuestion = 0;
    let timeLimit = 300; // 5 minutes in seconds

    //get questions from fetch_questions file
    function fetchQuestions() {
        $.ajax({
            url: 'fetch_questions.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                questions = data;
                displayQuestion();
                startTimer();
            }
        });
    }
    //check questioned or not finish
    function displayQuestion() {
        if (currentQuestion >= questions.length) {
            alert("Quiz completed!");
            return;
        }
        let q = questions[currentQuestion];
        $('#question').text(q.question);
        $('#option1').text(q.option1);
        $('#option2').text(q.option2);
        $('#option3').text(q.option3);
        $('#option4').text(q.option4);
    }

    function submitResponse(selectedOption) {
     alert(selectedOption);
     let q = questions[currentQuestion];
        $.ajax({
            url: 'submit_response.php',
            method: 'POST',
            data: {
                question_id: q.id,
                selected_option: selectedOption
            },
            success: function (response) {
                alert(response);
                currentQuestion++;
                displayQuestion();
            }
        });
    }

    //reduce the time 
    function startTimer() {
        let timer = setInterval(() => {
            if (timeLimit <= 0) {
                clearInterval(timer);
                alert("Time's up!");
                return;
            }

            //remaining time can get by timer
            $('#timer').text(`Time left: ${timeLimit} seconds`);
            timeLimit--;
        }, 1000);
    }

    $(document).ready(function () {
        fetchQuestions();
    });
</script>
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2>Quiz</h2>
            <ol>
                <li><a href="index.html">customer</a></li>
                <li>Quiz</li>
            </ol>
        </div>

    </div>
</section>
<section class="inner-page">
    <section id="cta">
        <div class="container" data-aos="zoom-in">
            <h1>Time Limited Quiz</h1>
            <div id="quiz">
                <div id="question"></div>
                <button onclick="submitResponse(1)" id="option1"></button>
                <button onclick="submitResponse(2)" id="option2"></button>
                <button onclick="submitResponse(3)" id="option3"></button>
                <button onclick="submitResponse(4)" id="option4"></button>
            </div>
            <div id="timer"></div>
        </div>
    </section><!-- End Cta Section -->
</section>
<?php
include '../footer.php';
?>