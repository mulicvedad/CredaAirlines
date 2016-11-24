var isModalPresented = false;

window.onclick = function(event) {
    var imageContainerDiv = document.getElementById("imagePresentationContainer");
    var imageElement = document.getElementById("imageFull");

    if (event.target == imageElement) {
        return;
    }
    if (event.target == imageContainerDiv) {
        imageContainerDiv.style.display = "none";
        isModalPresented = false;

    }
}

document.addEventListener('keydown', function(event) {
    if(event.keyCode == 27 && isModalPresented) {
        var imageContainerDiv = document.getElementById("imagePresentationContainer");
        imageContainerDiv.style.display = "none";
    }
});

function openImage(image) {
    isModalPresented = true;
    var closeButton = document.getElementById("closeButton");
    var imageContainerDiv = document.getElementById("imagePresentationContainer");
    var imageElement = document.getElementById("imageFull");
    closeButton.onclick=function () {
        imageContainerDiv.style.display = "none";
        isModalPresented = false;
    }
    imageContainerDiv.style.display = "block";
    imageElement.src=image.src;
    var imageWidthPercentage = 100*imageElement.width/window.innerWidth;
    closeButton.style.right=(100.0 - imageWidthPercentage) / 2 + "%";
}