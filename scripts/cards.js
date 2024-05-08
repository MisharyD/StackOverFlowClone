function addQuestions()
{
    //returns the 2 container for top and recent questions
    let recentQuestionContainer = document.querySelectorAll(".question-container");
    let card = document.querySelector(".question")

    //add questions both containers
    recentQuestionContainer.forEach((container) => 
        {
            for(let i = 0; i<10; i++)
                {   
                    let actualCard = changeQuestionAtt(i, card);
                    container.appendChild(actualCard);
                }
        })
}

//change the tag,answers,time, and question ids
function changeQuestionAtt(questionNb,card)
{
    let actualCard = card.cloneNode(true);
    actualCard.setAttribute("id", actualCard.getAttribute("id") + questionNb);
    tagContainer = actualCard.querySelector("#qTag");
    tagContainer.setAttribute("id", tagContainer.getAttribute("id") + questionNb);

    timeContainer = actualCard.querySelector("#qTime");
    timeContainer.setAttribute("id", timeContainer.getAttribute("id") + questionNb);

    nbOfAnswersContainer = actualCard.querySelector("#qAnswers");
    nbOfAnswersContainer.setAttribute("id", nbOfAnswersContainer.getAttribute("id") + questionNb);

    textContainer = actualCard.querySelector("#question");
    textContainer.setAttribute("id",textContainer.getAttribute("id") + questionNb);

    return actualCard;
}

function addRecentQuestionsInfo(questions, NbOfVotes, tags)
{
    console.log(questions);
    let questionsContainer = document.querySelector("#recent-questions-container")
    for(let i=0; i<questions.length; i++)
        {
            questionsContainer.querySelector("#qAnswers" + i).innerHTML = NbOfVotes[i].num_answers;
            questionsContainer.querySelector("#question" + i).innerHTML = questions[i].title;
            questionsContainer.querySelector("#qTime" + i).innerHTML = "Asked by " + questions[i].userName + " at " + questions[i].created_at; 

            let tagContainer = questionsContainer.querySelector("#qTag" + i);
            for(let j = 0; j<tags[i].length ; j++)
            {
                let tag = document.createElement("span")
                tag.classList.add("tag");
                //add tag j for question i
                tag.innerHTML = tags[i][j].tagName;
                tagContainer.appendChild(tag);
            }
            questionsContainer.querySelector("#card" + i).style.display = "flex";
        }
}