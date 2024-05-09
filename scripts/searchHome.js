
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
