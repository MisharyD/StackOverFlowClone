document.querySelectorAll(".QA-button").forEach(button => button.addEventListener("click", changeDisplayedPageType));

function addQuestionsPage(nbOfQuestions, containerId)
{
    let pagesContainer = document.querySelector("#" + containerId);
    let buttonContainer = document.querySelector(".pages-button-container");
    nbOfPages = Math.ceil(nbOfQuestions/10);

    for(let i = 0; i < nbOfPages; i++)
    {
        //create page and add questions to it
        let page = document.createElement("div");
        page.classList.add("question-container");
        pagesContainer.appendChild(page);
        page.setAttribute("id","page" + i);
        if(nbOfQuestions >= 10)
            addQuestions(page.getAttribute("id"),10);
        else
            addQuestions(page.getAttribute("id"), nbOfQuestions);
        page.style.display ="none";
        
        //create a button for each page
        let pageButton = document.querySelector(".pageButton").cloneNode(true);
        pageButton.setAttribute("id", "pageButton" + i);
        pageButton.innerHTML = i + 1;
        pageButton.addEventListener("click",changeDisplayedPage);
        pageButton.style.display = "inline"
        buttonContainer.appendChild(pageButton);

        //to use at the last page to know how many questions are left
        nbOfQuestions -= 10;
    }
    //display the first page as default
    document.querySelector("#page0").style.display = "block";
}

function addQuestions(containerId,nbOfQuestions)
{
    let questionsContainer = document.querySelector("#" + containerId);
    let card = document.querySelector(".question")

    for(let i = 0; i<nbOfQuestions; i++)
        {   
            let actualCard = changeQuestionAtt(i, card);
            //temp solution until I figure out what is changing the display to block
            actualCard.style.display = "flex";
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

    actualCard.style.display = "block";
    return actualCard;
}

function addInfoToPages()
{

}

function addQuestionsInfo(questions, tags, containerId)
{
    nbOfPages = Math.ceil(questions.length /10);
    let pagesContainer = document.querySelector("#" + containerId);
    let nbOfQuestions = questions.length;
    for(let i=0; i< nbOfPages; i++)
    {   
        let questionsContainer = pagesContainer.querySelector("#page" + i);
        let loopIterator;
        if(nbOfQuestions >= 10)
            loopIterator = 10;
        else
            loopIterator = nbOfQuestions;

        for(let j=0; j<loopIterator; j++)
        {
            questionsContainer.querySelector("#qAnswers" + j).innerHTML = questions[j + (i *10)]["num_answers"];
            questionsContainer.querySelector("#question" + j).innerHTML = questions[j + (i *10)]["title"];
            questionsContainer.querySelector("#qTime" + j).innerHTML = "Asked by " + questions[j + (i *10)]["username"] + " at " + questions[j].created_at; 

            let tagContainer = questionsContainer.querySelector("#qTag" + j);
            for(let k = 0; k<tags[j].length ; k++)
            {
                let tag = document.createElement("span")
                tag.classList.add("tag");
                //add tag j for question i
                tag.innerHTML = tags[j][k].tagName;
                tagContainer.appendChild(tag);
            }
            questionsContainer.querySelector("#card" + j).style.display = "flex";
        }

        //to use at the last page to know how many questions are left
        nbOfQuestions -= 10;
    }
} 

function changeDisplayedPage(e)
{
    let pageNumber = e.target.getAttribute("id").match(/\d+$/)[0];
    let pageToDisplay = document.querySelector("#page" + pageNumber);
    pageToDisplay.style.display = "block";

    let allPages = document.querySelectorAll(".question-container");
        allPages.forEach(page => {
            let computedStyle = window.getComputedStyle(page);
            if (computedStyle.getPropertyValue('display') === 'block' && page.getAttribute("id") != pageToDisplay.getAttribute("id"))
                page.style.display = "none";
        });
}


function changeDisplayedPageType(e)
{
    let typeDisplayed = e.target;
    if(typeDisplayed.getAttribute("id") == "question-type")
    {
        document.querySelector("#questions-pages-container").style.display = "block";
        document.querySelector("#answers-pages-container").style.display = "none";
    }
    else 
    {
        document.querySelector("#questions-pages-container").style.display = "none";
        document.querySelector("#answers-pages-container").style.display = "block";
    }
}
