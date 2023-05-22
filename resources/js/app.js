import './bootstrap';

let fileInput = document.querySelector('input[type=file]');
let filePreview = fileInput.previousElementSibling.querySelector('img');
if (fileInput) {
    fileInput.addEventListener('change', function () {
        let reader = new FileReader();
        reader.addEventListener('load', function () {
            filePreview.src = reader.result;
        });
        reader.readAsDataURL(this.files[0]);
    });
}