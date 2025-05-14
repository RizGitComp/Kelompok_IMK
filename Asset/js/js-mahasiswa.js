let selectedRow = null;

function selectMahasiswa(row) {
  if (selectedRow) selectedRow.style.backgroundColor = '';
  selectedRow = row;
  row.style.backgroundColor = '#e3f2fd';
  document.getElementById("routeBtn").style.display = "inline-block";
}

function showRoute() {
  if (!selectedRow) return;
  const alamat = selectedRow.cells[4].textContent;
  const url = "https://www.google.com/maps?q=" + encodeURIComponent(alamat);
  window.open(url, "_blank");
}

function searchMahasiswa() {
  const input = document.getElementById("searchInput").value.toLowerCase();
  const rows = document.querySelectorAll("#mahasiswaTable tbody tr");
  rows.forEach(row => {
    const nama = row.cells[1].textContent.toLowerCase();
    row.style.display = nama.includes(input) ? "" : "none";
  });
}