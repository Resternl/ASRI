document.querySelectorAll(".status-select").forEach(select => {
  select.addEventListener("change", function () {

    const idSiswa = this.dataset.id;
    const statusBaru = this.value;

    console.log("Update:", idSiswa, "->", statusBaru);

    fetch("absen.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: `id_siswa=${idSiswa}&status=${statusBaru}`
    })
    .then(res => res.text())
    .then(result => {
      console.log("SERVER:", result);
    })
    .catch(err => {
      console.error("ERROR UPDATE:", err);
      alert("Gagal menyimpan status!");
    })

  })
})
