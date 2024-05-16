// Attach click event listeners to each anchor
document.addEventListener("DOMContentLoaded",function()
{
    // Get all anchors with class "qat"
    var qaAnchors = document.querySelectorAll('.qat');
    for (var i = 0; i < qaAnchors.length; i++) {
        qaAnchors[i].addEventListener('click', handleQAClick);
    }
})

// Function to handle click on anchors with class "qat"
function handleQAClick(event) {
    // Prevent the default behavior of the anchor (e.g., page navigation)
    event.preventDefault();
    // Get the text content of the clicked anchor
    var questionText = this.textContent;
    // Construct the URL using the extracted text
    var destinationURL = 'question.php?qat=' + encodeURIComponent(questionText);
    // Navigate to the constructed URL
    window.location.href = destinationURL;
}