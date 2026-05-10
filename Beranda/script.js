// Toggle kelas active untuk search form
const searchForm = document.querySelector(".search-form");
const searchBox = document.querySelector("#search-box");

document.querySelector("#search-icon").onclick = (e) => {
  e.preventDefault(); // Mencegah link pindah halaman/refresh
  searchForm.classList.toggle("active");
  searchBox.focus();
};

// Opsional: Klik di luar search form untuk menutupnya
document.addEventListener("click", function (e) {
  const searchIcon = document.querySelector("#search-icon");
  if (!searchIcon.contains(e.target) && !searchForm.contains(e.target)) {
    searchForm.classList.remove("active");
  }
});
