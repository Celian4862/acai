document.addEventListener("DOMContentLoaded", function() {
    const element = document.querySelector('nav');
    const elementHeight = element.offsetHeight;

    const elem = document.querySelector('footer');
    const elemHeight = elem.offsetHeight;

    const newHeight = `calc(100vh - ${elementHeight}px)`;
    const newHeight2 = `calc(100vh - ${elementHeight}px - ${elemHeight}px)`;

    const signupBg = document.querySelector('.signup-bg');
    const loginBg = document.querySelector('.login-bg');
    const backgroundHalf = document.querySelector('.background-half');

    if (signupBg) {
        signupBg.style.height = newHeight2;
    }
    if (loginBg) {
        loginBg.style.height = newHeight2;
    }
    if (backgroundHalf) {
        backgroundHalf.style.height = newHeight;
    }
});

let pageNum = 0;

function addFile() {
    if (pageNum == 0) {
        const newDiv1 = document.createElement('div');
        newDiv1.id = `img-msg`;
        newDiv1.className = 'alert alert-info';
        newDiv1.innerHTML = `
            <p>Image must be JPG, JPEG, or PNG.</p>
        `;
        document.getElementById('add-file').before(newDiv1);
    }
    pageNum++;
    const newDiv = document.createElement('div');
    newDiv.id = `image${pageNum}`;
    newDiv.className = 'mb-3';
    newDiv.innerHTML = `
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <input type="file" name="images[]" class="form-control" accept=".jpg, .jpeg, .png">
                </div>
                <div class="col-md justify-content-center">
                    <button type="button" class="btn btn-secondary" onclick="removeFile('image${pageNum}')">Remove Image</button>
                </div>
            </div>
        </div>
    `;
    document.getElementById('add-file-mark').before(newDiv);
}

function removeFile(elementId) {
    if (pageNum == 1) {
        const msg = document.getElementById('img-msg');
        if (msg) {
            msg.remove();
        }
    }
    const element = document.getElementById(elementId);
    if (element) {
        element.remove();
        pageNum--;
    }
}