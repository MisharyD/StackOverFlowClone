document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".delete").forEach((button) => button.addEventListener("click", function(e) {
        var confirmation = confirm("Are you sure you want to delete?");

        if (confirmation) {
            //this method was used to avoid searching using IDs
            let card = e.target.parentNode.parentNode.parentNode
            //determines if the card is a question card or an answer card
            let type = card.classList.contains("questionCard");
            let deletePram = card.querySelector("a").innerHTML;
            url = 'userHome.php?type=' + encodeURIComponent(type) + "&deletePram=" + encodeURIComponent(deletePram);
            window.location.href = url;
        }
    }));
})

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".edit").forEach((button) => button.addEventListener("click", function(e) {

        let card = e.target.parentNode.parentNode.parentNode
        //determines if the card is a question card or an answer card
        let title = card.querySelector("a").innerHTML;
        url = 'editQuestion.php?qat=' + encodeURIComponent(title);
        window.location.href = url;
    }));
})

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".editAnswer").forEach((button) => button.addEventListener("click", function(e) {

        let card = e.target.parentNode.parentNode.parentNode
        //determines if the card is a question card or an answer card
        let description = card.querySelector("a").innerHTML;
        let time = card.querySelector(".time").innerText.split("at")[1].trim();
        console.log(time);
        url = 'editAnswer.php?description=' + encodeURIComponent(description) + "&created_at=" + encodeURIComponent(time) ;
        window.location.href = url;
    }));
})