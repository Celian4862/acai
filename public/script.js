document.addEventListener("DOMContentLoaded", function() {
    const element = document.querySelector('nav');
    const elementHeight = element.offsetHeight;
    const newHeight = `calc(100vh - ${elementHeight}px)`;
    const backgroundHalf = document.querySelector('.background-half');
    backgroundHalf.style.height = newHeight;
});

let pageNum = 0;

function addFile() {
    pageNum++;
    const newDiv = document.createElement('div');
    newDiv.id = `image${pageNum}`;
    newDiv.className = 'mb-3';
    newDiv.innerHTML = `
        <input type="file" class="form-control">
        <button type="button" class="btn btn-secondary mt-2" onclick="removeFile('image${pageNum}')">Remove Image</button>
    `;
    document.getElementById('add-file').before(newDiv);
}

function removeFile(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.remove();
        pageNum--;
    }
}