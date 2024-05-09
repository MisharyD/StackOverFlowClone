<!-- line 54 Extra no need for bio -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/test.css">
    <link rel="stylesheet" href="styles/home.css">
</head>
<body>
<!-- Header part-->
<?php include("header.php");?>;
<!-- Body part-->
<div class="body">
    <div class="container">
    <div class="left-body-container">
                <ul class="tab-container">
                    <li class="tab">
                        <img src="images/homeIcon.png" width="20px" height=auto>
                        <div>Home</div>
                    </li>
                    <li class="current-page tab"> 
                        <img src="images/question.png" width="15px" height=auto>
                        <div> Questions</div>
                    </li>
                    <li class="tab"> 
                        <img src="images/user.png" width="20px" height=auto>
                        <div> Users</div>
                    </li>
                    <li class="tab"> <img src="images/tag.png" width="20px" height=auto>
                        <div>Tags</div>
                    </li>
                </ul>
            </div>

        <div class="middle-body-container">
            <div class="container">
                <div class="right-side">

                    <div class="bio"><!-- Extra no need -->
                        <h2>Search Result</h2>
                    </div>   

                    <div class="content-box question-box">
                        <!-- Question cards will be dynamically generated here -->
                    </div>

                    <!-- Pagination for Question Cards -->
                    <div id="questionPagination" class="pagination"></div>

                    <script>
                        // JavaScript code to toggle visibility of question and answer boxes
                        const questionButton = document.getElementById('questionButton');
                        const questionBox = document.querySelector('.question-box');
                        const questionPagination = document.getElementById('questionPagination');
                        const pageSize = 10; // Number of cards per page
                        let currentPage = 1; // Current page number

                        
                        // JavaScript function to generate question cards dynamically
                        function displayQuestions(page) {
                            questionBox.innerHTML = '';
                            const startIndex = (page - 1) * pageSize + 1;
                            const endIndex = Math.min(startIndex + pageSize - 1, 10);

                            for (let i = startIndex; i <= endIndex; i++) {
                                questionBox.innerHTML += `<div class="card">
                                    <h3>Question Title ${i}</h3>
                                    <div style="font-size: 14px">questions descrition</div>
                                    <p style="display: inline; font-size: 14px">Tags: HTML, CSS, JavaScript</p>
                                    <p style="display: inline; font-size: 14px">Number of Answers: 5</p>
                                    <p class="date">Date Published: May 7, 2024</p>
                                </div>`;
                            }

                            updateQuestionPagination();
                        }


                        // JavaScript function to update question pagination
                        function updateQuestionPagination() {
                            questionPagination.innerHTML = '';

                            const numPages = Math.ceil(10 / pageSize);

                            for (let i = 1; i <= numPages; i++) {
                                const pageButton = document.createElement('button');
                                pageButton.textContent = i;
                                pageButton.addEventListener('click', function() {
                                    currentPage = i;
                                    displayQuestions(currentPage);
                                });
                                questionPagination.appendChild(pageButton);
                            }
                        }

                        // Display initial page for questions
                        displayQuestions(currentPage);
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>