function addQuestions(containerId,nbOfQuestions)
{
    let questionsContainer = document.querySelector("#" + containerId);
    let card = document.querySelector(".question")

    //add questions both containers
    for(let i = 0; i<nbOfQuestions; i++)
        {   
            let actualCard = changeQuestionAtt(i, card);
            questionsContainer.appendChild(actualCard);
        }
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

function addQuestionsInfo(questions, tags, containerId)
{
    
    console.log(questions);
    let questionsContainer = document.querySelector("#" + containerId);
    for(let i=0; i<questions.length; i++)
        {
            questionsContainer.querySelector("#qAnswers" + i).innerHTML = questions[i]["num_answers"];
            questionsContainer.querySelector("#question" + i).innerHTML = questions[i]["title"];
            questionsContainer.querySelector("#qTime" + i).innerHTML = "Asked by " + questions[i]["username"] + " at " + questions[i].created_at; 

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