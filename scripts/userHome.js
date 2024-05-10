// JavaScript code to toggle visibility of question and answer boxes
const questionButton = document.getElementById('questionButton');
const answerButton = document.getElementById('answerButton');
const questionBox = document.querySelector('.question-box');
const answerBox = document.querySelector('.answer-box');
const questionPagination = document.getElementById('questionPagination');
const answerPagination = document.getElementById('answerPagination');
const pageSize = 10; // Number of cards per page
let currentPage = 1; // Current page number

questionButton.addEventListener('click', function() {
    // Toggle active class on the buttons
    this.classList.add('active');
    answerButton.classList.remove('active');

    // Toggle visibility of question and answer boxes
    questionBox.style.display = 'block';
    answerBox.style.display = 'none';

    // Show question pagination and hide answer pagination
    questionPagination.style.display = 'block';
    answerPagination.style.display = 'none';

    // Display initial page for questions
    displayQuestions(currentPage);
});

answerButton.addEventListener('click', function() {
    // Toggle active class on the buttons
    this.classList.add('active');
    questionButton.classList.remove('active');

    // Toggle visibility of question and answer boxes
    questionBox.style.display = 'none';
    answerBox.style.display = 'block';

    // Show answer pagination and hide question pagination
    answerPagination.style.display = 'block';
    questionPagination.style.display = 'none';

    // Display initial page for answers
    displayAnswers(currentPage);
});

// JavaScript function to generate question cards dynamically
function displayQuestions(page) {
    questionBox.innerHTML = '';
    const startIndex = (page - 1) * pageSize + 1;
    const endIndex = Math.min(startIndex + pageSize - 1, 10);

    for (let i = startIndex; i <= endIndex; i++) {
        questionBox.innerHTML += `<div class="card">
            <div class="card-buttons">
                <button class="edit-button">Edit</button>
                <button class="delete-button">Delete</button>
            </div>
            <h3>Question Title ${i}</h3>
            <p>Number of Answers: 5</p>
            <p>Tags: HTML, CSS, JavaScript</p>
            <p class="date">Date Published: May 7, 2024</p>
        </div>`;
    }

    updateQuestionPagination();
}

// JavaScript function to generate answer cards dynamically
function displayAnswers(page) {
    answerBox.innerHTML = '';
    const startIndex = (page - 1) * pageSize + 1;
    const endIndex = Math.min(startIndex + pageSize - 1, 10);

    for (let i = startIndex; i <= endIndex; i++) {
        answerBox.innerHTML += `<div class="card">
            <div class="card-buttons">
                <button class="edit-button">Edit</button>
                <button class="delete-button">Delete</button>
            </div>
            <h3>Name of Answered Question${i}</h3>
            <p>Average Rating: 4.5</p>
            <p>Tags: HTML, CSS, JavaScript</p>
            <p class="date">Date Published: May 7, 2024</p>
        </div>`;
    }

    updateAnswerPagination();
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

// JavaScript function to update answer pagination
function updateAnswerPagination() {
    answerPagination.innerHTML = '';

    const numPages = Math.ceil(10 / pageSize);

    for (let i = 1; i <= numPages; i++) {
        const pageButton = document.createElement('button');
        pageButton.textContent = i;
        pageButton.addEventListener('click', function() {
            currentPage = i;
            displayAnswers(currentPage);
        });
        answerPagination.appendChild(pageButton);
    }
}


