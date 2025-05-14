console.log("✅ JS file loaded");

let selectedNIM = null;
let selectedAlamat = null;
let selectedRow = null;

document.addEventListener("DOMContentLoaded", () => {
  const table = document.getElementById("mahasiswaTable");
  if (table) {
    table.addEventListener("click", (e) => {
      const tr = e.target.closest("tr");
      if (!tr || tr.parentElement.tagName !== "TBODY") return;
      selectRow(tr);
    });
  }

  const editBtn = document.getElementById("editBtn");
  if (editBtn) editBtn.addEventListener("click", editData);

  const deleteBtn = document.getElementById("deleteBtn");
  if (deleteBtn) deleteBtn.addEventListener("click", hapusData);

  const routeBtn = document.getElementById("routeBtn");
  if (routeBtn) routeBtn.addEventListener("click", showRoute);

  const searchInput = document.getElementById("searchInput");
  if (searchInput) searchInput.addEventListener("input", searchMahasiswa);
});

function selectRow(row) {
  if (selectedRow) selectedRow.style.backgroundColor = '';
  selectedRow = row;
  row.style.backgroundColor = '#e3f2fd';
  selectedNIM = row.dataset.nim;
  selectedAlamat = row.dataset.alamat;
  setToolbarState(true);
}

function setToolbarState(enabled) {
  ["editBtn", "deleteBtn", "routeBtn"].forEach(id => {
    const btn = document.getElementById(id);
    if (btn) btn.disabled = !enabled;
  });
}

function editData() {
  if (selectedNIM) window.location.href = "edit.php?nim=" + selectedNIM;
}

function hapusData() {
  if (selectedNIM && confirm("Yakin ingin menghapus data ini?")) {
    window.location.href = "delete.php?nim=" + selectedNIM;
  }
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
    const alamat = row.cells[4].textContent.toLowerCase();
    row.style.display = alamat.includes(input) ? "" : "none";
  });
}
