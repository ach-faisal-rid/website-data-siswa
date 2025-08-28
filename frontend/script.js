const API_BASE = "http://localhost/smkti/website-data-siswa/backend";
let dataSiswa = [];
let editMode = false;

// ===== Toast Function =====
function showToast(message, type = "success") {
  const container = document.getElementById("toast-container");
  const toast = document.createElement("div");
  toast.className = `toast ${type}`;
  toast.textContent = message;

  container.appendChild(toast);

  // Trigger animation
  setTimeout(() => toast.classList.add("show"), 100);

  // Auto remove after 3s
  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => container.removeChild(toast), 400);
  }, 3000);
}

// ===== Ambil Data =====
function ambilData() {
  fetch(`${API_BASE}/siswa.php?ts=${Date.now()}`)
    .then((res) => res.json())
    .then((data) => {
      dataSiswa = data;
      tampilkanData(dataSiswa);
    });
}
ambilData();

// ===== Tampilkan Data =====
function tampilkanData(data) {
  const list = document.getElementById("daftarSiswa");
  const pesan = document.getElementById("pesan");
  list.innerHTML = "";
  pesan.textContent = "";

  if (data.length === 0) {
    pesan.textContent = "Data siswa belum tersedia.";
    return;
  }

  data.forEach((siswa) => {
    const li = document.createElement("li");
    li.innerHTML = `
          <span>${siswa.nama} - ${siswa.kelas}</span>
          <div class="actions">
            <button class="btn btn-edit" onclick="editSiswa(${siswa.id}, '${siswa.nama}', '${siswa.kelas}')">Edit</button>
            <button class="btn btn-delete" onclick="hapusSiswa(${siswa.id})">Hapus</button>
          </div>
        `;
    list.appendChild(li);
  });
}

// ===== Tambah / Update Data =====
document.getElementById("simpanBtn").addEventListener("click", function () {
  const id = document.getElementById("id").value;
  const nama = document.getElementById("nama").value.trim();
  const kelas = document.getElementById("kelas").value.trim();

  if (!nama || !kelas) {
    showToast("Nama dan kelas harus diisi!", "error");
    return;
  }

  if (editMode) {
    // Update
    fetch(`${API_BASE}/edit-siswa.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, nama, kelas }),
    })
      .then((res) => res.json())
      .then((res) => {
        showToast(res.status, "success");
        resetForm();
        ambilData();
      })
      .catch(() => showToast("Gagal update data!", "error"));
  } else {
    // Tambah
    fetch(`${API_BASE}/tambah-siswa.php`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ nama, kelas }),
    })
      .then((res) => res.json())
      .then((res) => {
        showToast(res.status, "success");
        resetForm();
        ambilData();
      })
      .catch(() => showToast("Gagal tambah data!", "error"));
  }
});

// ===== Edit Data =====
function editSiswa(id, nama, kelas) {
  document.getElementById("id").value = id;
  document.getElementById("nama").value = nama;
  document.getElementById("kelas").value = kelas;
  document.getElementById("simpanBtn").textContent = "Update";
  document.getElementById("simpanBtn").className = "btn btn-edit";
  editMode = true;
}

// ===== Hapus Data =====
function hapusSiswa(id) {
  Swal.fire({
    title: "Yakin ingin hapus?",
    text: "Data yang sudah dihapus tidak bisa dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, hapus",
    cancelButtonText: "Batal",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`${API_BASE}/hapus-siswa.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id }),
      })
        .then((res) => res.json())
        .then((res) => {
          Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: "Berhasil hapus data!",
            showConfirmButton: false,
            timer: 2000,
          });
          ambilData();
        })
        .catch(() => {
          Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: "Gagal hapus data!",
            showConfirmButton: false,
            timer: 2000,
          });
        });
    }
  });
}

// ===== Reset Form =====
function resetForm() {
  document.getElementById("id").value = "";
  document.getElementById("nama").value = "";
  document.getElementById("kelas").value = "";
  document.getElementById("simpanBtn").textContent = "Tambah";
  document.getElementById("simpanBtn").className = "btn btn-add";
  editMode = false;
}

document.getElementById("batalBtn").addEventListener("click", resetForm);

// ===== Pencarian =====
document.getElementById("tombolCari").addEventListener("click", function () {
  const keyword = document.getElementById("cari").value.toLowerCase().trim();
  const hasilFilter = dataSiswa.filter(
    (siswa) =>
      siswa.nama.toLowerCase().includes(keyword) ||
      siswa.kelas.toLowerCase().includes(keyword)
  );
  tampilkanData(hasilFilter);
});
