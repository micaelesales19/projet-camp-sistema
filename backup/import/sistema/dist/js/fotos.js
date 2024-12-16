let photo1 = document.getElementById('imgPhoto_usuario');
let file1 = document.getElementById('fileImage_usuario');

let photo2 = document.getElementById('imgPhoto_colider');
let file2 = document.getElementById('fileImage_colider');

photo1.addEventListener("click", () => {
    file1.click();
});

file1.addEventListener('change', (event) => {

    if (file1.files.length <= 0) {
        return;
    }

    let reader = new FileReader();
    reader.onload = () => {
        photo1.src = reader.result;
    }
    reader.readAsDataURL(file1.files[0]);
});

photo2.addEventListener("click", () => {
    file2.click();
});

file2.addEventListener('change', (event) => {

    if (file2.files.length <= 0) {
        return;
    }

    let reader = new FileReader();
    reader.onload = () => {
        photo2.src = reader.result;
    }
    reader.readAsDataURL(file2.files[0]);
});