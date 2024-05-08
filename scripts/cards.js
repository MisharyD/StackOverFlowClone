document.addEventListener("DOMContentLoaded",addQuestions);

function addQuestions()
{
    //returns the 2 container for top and recent questions
    let recentQuestionContainer = document.querySelectorAll(".question-container");
    let card = document.querySelector(".question")

    //add questions both containers
    recentQuestionContainer.forEach((container) => 
        {
            for(let i = 1; i<=10; i++)
                {   
                    let actualCard = changeQuestionAtt(i, card);
                    container.appendChild(actualCard);
                }
        })
}

//change the vote,answers and question ids
function changeQuestionAtt(questionNb,card)
{
    let actualCard = card.cloneNode(true);
    nbOfVotesContainer = actualCard.querySelector("#qVotes");
    nbOfVotesContainer.setAttribute("id", nbOfVotesContainer.getAttribute("id") + questionNb);

    tagContainer = actualCard.querySelector("#qTag");
    tagContainer.setAttribute("id", tagContainer.getAttribute("id") + questionNb);

    nbOfAnswersContainer = actualCard.querySelector("#qAnswers");
    nbOfAnswersContainer.setAttribute("id", nbOfAnswersContainer.getAttribute("id") + questionNb);

    textContainer = actualCard.querySelector("#question");
    textContainer.setAttribute("id",textContainer.getAttribute("id") + questionNb);

    actualCard.style.display = "flex";
    return actualCard;
}