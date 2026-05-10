//Toggle kelas active untuk search form//
const searchForm = document.querySelector('.search-form');
const searchBox = document.querySelector('#search-box');

document.querySelector('#search-icon').onclick = () => {
    searchForm.classList.toggle('active');
    searchBox.focus();
}
