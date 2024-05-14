document.querySelectorAll(".QA-button").forEach(button => button.addEventListener("click", changeDisplayedPageType));

function addQuestionsPage(nbOfQuestions, containerId)
{
    let pagesContainer = document.querySelector("#" + containerId);
    let buttonContainer = document.querySelector(".question-pages-button-container");
    nbOfPages = Math.ceil(nbOfQuestions/10);

    for(let i = 0; i < nbOfPages; i++)
    {
        //create page and add questions to it
        let page = document.createElement("div");
        page.classList.add("question-container");
        pagesContainer.appendChild(page);
        page.setAttribute("id","page" + i);
        if(nbOfQuestions >= 10)
            addQuestionCards(page.getAttribute("id"),10);
        else
            addQuestionCards(page.getAttribute("id"), nbOfQuestions);
        page.style.display ="none";
        
        //create a button for each page
        let pageButton = document.querySelector(".pageButton").cloneNode(true);
        pageButton.setAttribute("id", "pageButton" + i);
        pageButton.innerHTML = i + 1;
        pageButton.addEventListener("click",(e) => {
            let target = e.target;
            changeDisplayedPage(target,pagesContainer)});
        pageButton.style.display = "inline"
        buttonContainer.appendChild(pageButton);

        //to use at the last page to know how many questions are left
        nbOfQuestions -= 10;
    }
    //display the first page as default
    pagesContainer.querySelector("#page0").style.display = "block";
    //make question button background orange
    document.querySelector("#question-type").classList.add("active");
    //make page1 button background orange
    buttonContainer.querySelector("#pageButton0").classList.add("active");
}

function addAnswersPage(nbOfAnswers, containerId)
{
    let pagesContainer = document.querySelector("#" + containerId);
    let buttonContainer = document.querySelector(".answer-pages-button-container");

    nbOfPages = Math.ceil(nbOfAnswers/10);
    for(let i = 0; i < nbOfPages; i++)
        {
            //create page and add answers to it
            let page = document.createElement("div");
            //some functions use the question-container class to find the cards, any css specified for cards will be done using answer container to overwrite
            page.classList.add("question-container");

            page.classList.add("answer-container");
            pagesContainer.appendChild(page);
            page.setAttribute("id","page" + i);
            if(nbOfAnswers >= 10)
                addAnswerCards(pagesContainer, page.getAttribute("id"),10,);
            else
                addAnswerCards(pagesContainer, page.getAttribute("id"), nbOfAnswers);
            page.style.display ="none";
            
            //create a button for each page
            let pageButton = document.querySelector(".pageButton").cloneNode(true);
            pageButton.setAttribute("id", "pageButton" + i);
            pageButton.innerHTML = i + 1;
            pageButton.addEventListener("click",(e) => {
                let target = e.target;
                changeDisplayedPage(target,pagesContainer)});
            pageButton.style.display = "inline"
            buttonContainer.appendChild(pageButton);
    
            //to use at the last page to know how many questions are left
            nbOfAnswers -= 10;
        }

    //display the first page as default
    pagesContainer.querySelector("#page0").style.display = "block";
    //make question button background orange
    document.querySelector("#question-type").classList.add("active");
    //make page1 button background orange
    buttonContainer.querySelector("#pageButton0").classList.add("active");
}


function addQuestionCards(containerId,nbOfCards)
{
    let container = document.querySelector("#" + containerId);
    let card = document.querySelector(".questionCard")

    for(let i = 0; i<nbOfCards; i++)
        {   
            let actualCard = changeQuestionCardAtt(i, card);

            //temp solution until I figure out what is changing the display to block
            actualCard.style.display = "flex";

            container.appendChild(actualCard);
        }
}

function addAnswerCards(pageContainer, pageId,nbOfCards)
{
    let container = pageContainer.querySelector("#" + pageId);
    let card = document.querySelector(".answerCard");
    for(let i = 0; i<nbOfCards; i++)
        {   
            let actualCard = changeAnswerCardAtt(i, card);
            //temp solution until I figure out what is changing the display to block
            actualCard.style.display = "flex";
            container.appendChild(actualCard);
        }
}



//change the tag,answers,time, and question ids
function changeQuestionCardAtt(questionNb,card)
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

function changeAnswerCardAtt(answerNb,card)
{
    let actualCard = card.cloneNode(true);
    actualCard.setAttribute("id", actualCard.getAttribute("id") + answerNb);
    tagContainer = actualCard.querySelector("#qTag");
    tagContainer.setAttribute("id", tagContainer.getAttribute("id") + answerNb);

    timeContainer = actualCard.querySelector("#aTime");
    timeContainer.setAttribute("id", timeContainer.getAttribute("id") + answerNb);

    nbOfAnswersContainer = actualCard.querySelector("#aRating");
    nbOfAnswersContainer.setAttribute("id", nbOfAnswersContainer.getAttribute("id") + answerNb);

    textContainer = actualCard.querySelector("#answer");
    textContainer.setAttribute("id",textContainer.getAttribute("id") + answerNb);

    return actualCard;
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

function addAnswersInfo(answers, avgRating, tags, containerId)
{
    nbOfPages = Math.ceil(answers.length /10);
    let pagesContainer = document.querySelector("#" + containerId);
    let nbOfAnswers = answers.length;
    for(let i=0; i< nbOfPages; i++)
    {  
        let answersContainer = pagesContainer.querySelector("#page" + i);
        let loopIterator;
        if(nbOfAnswers >= 10)
            loopIterator = 10;
        else
            loopIterator = nbOfAnswers;

        for(let j=0; j<loopIterator; j++)
        {
            answersContainer.querySelector("#aRating" + j).innerHTML = avgRating[j + (i *10)];

            //manual elipsis
            let description;
            // if(answers[j + (i *10)]["description"].length > 40)
            //     {
            //         description = answers[j + (i *10)]["description"].substring(0,40) + "...";
            //     }
            // else

            description = answers[j + (i *10)]["description"];
            answersContainer.querySelector("#answer" + j).innerHTML = description;
            answersContainer.querySelector("#aTime" + j).innerHTML = "Answered by " + answers[j + (i *10)]["userName"] + " at " + answers[j + (i *10)].created_at; 

            let tagContainer = answersContainer.querySelector("#qTag" + j);
            for(let k = 0; k<tags[j].length ; k++)
            {
                let tag = document.createElement("span")
                tag.classList.add("tag");
                //add tag j for question i
                tag.innerHTML = tags[j][k].tagName;
                tagContainer.appendChild(tag);
            }
            answersContainer.querySelector("#card" + j).style.display = "flex";
        }

        //to use at the last page to know how many questions are left
        nbOfAnswers -= 10;
    }
}


function changeDisplayedPage(target,pagesContainer)
{
    let pageNumber = target.getAttribute("id").match(/\d+$/)[0];
    let pageToDisplay = pagesContainer.querySelector("#page" + pageNumber);
    pageToDisplay.style.display = "block";

    //this is kinda hard coded needs changing
    let allPages = pagesContainer.querySelectorAll(".question-container");

        allPages.forEach(page => {
            let computedStyle = window.getComputedStyle(page);
            if (computedStyle.getPropertyValue('display') === 'block' && page.getAttribute("id") != pageToDisplay.getAttribute("id"))
                page.style.display = "none";
        });

    //tmp hard coded solution to not mix answer and questions pages buttons
    let buttonContainer;
    if(pagesContainer.getAttribute("id") == "questions-pages-container")
    {
        buttonContainer = document.querySelector("#question-pages-button-container");
    }
    else 
    {
        buttonContainer = document.querySelector("#answer-pages-button-container");
    }
        
    //add orange background to current page number
    currentButton = buttonContainer.querySelector("#pageButton" + pageNumber);
    currentButton.classList.add("active");

    //remove the orange background from the previos page number 
    let allPageButtons = buttonContainer.querySelectorAll(".pageButton");
    allPageButtons.forEach(button => {
            let classes = button.classList;
            if (classes.contains("active") && button.getAttribute("id") != currentButton.getAttribute("id"))
                button.classList.remove("active");
        });
    
}


function changeDisplayedPageType(e)
{
    let buttonType = e.target;
    if(buttonType.getAttribute("id") == "question-type")
    {
        //display the question page and their buttons and add class active to the question button
        document.querySelector("#questions-pages-container").style.display = "block";
        document.querySelector(".question-pages-button-container").style.display = "block";
        buttonType.classList.add("active");
        

        document.querySelector("#answers-pages-container").style.display = "none";
        document.querySelector(".answer-pages-button-container").style.display = "none";
        document.querySelector("#answer-type").classList.remove("active");
    }
    else 
    {
        //display the answer page and add class active to the answer bautton
        document.querySelector("#questions-pages-container").style.display = "none";
        document.querySelector(".question-pages-button-container").style.display = "none";
        document.querySelector("#question-type").classList.remove("active");

        document.querySelector("#answers-pages-container").style.display = "block";
        document.querySelector(".answer-pages-button-container").style.display = "block";
        buttonType.classList.add("active");
    }
}

