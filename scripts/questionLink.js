// Attach click event listeners to each anchor
document.addEventListener("DOMContentLoaded",function()
{
    // Get all anchors with class "qat"
    var qaAnchors = document.querySelectorAll('.qat');
    for (var i = 0; i < qaAnchors.length; i++) {
        qaAnchors[i].addEventListener('click', handleQAClick);
    }
})