document.addEventListener('DOMContentLoaded', () => {

    // Ambil elemen-elemen penting
    const container = document.getElementById('category-crud-container');
    
    // === PERBAIKAN 1: Inisialisasi Modal di sini ===
    const modalEl = document.getElementById('category-modal');
    const modal = new bootstrap.Modal(modalEl); // Buat objek Modal Bootstrap
    // ===============================================

    const form = document.getElementById('category-form');
    const btnAdd = document.getElementById('btn-add-category');
    const modalTitle = document.getElementById('modal-title');
    const hiddenId = document.getElementById('category_id');
    const tableBody = document.getElementById('category-table-body');
    const notificationArea = document.getElementById('notification-area');

    // Ambil URL
    const URL_STORE = container.dataset.storeUrl;
    const URL_EDIT = container.dataset.editUrl;
    const URL_UPDATE = container.dataset.updateUrl;
    const URL_DELETE = container.dataset.deleteUrl;

    // Ambil CSRF
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Fungsi untuk membuka modal (DIPERBAIKI)
    const openModal = (mode = 'create', id = null) => {
        form.reset();
        clearErrors();
        hiddenId.value = '';

        if (mode === 'create') {
            modalTitle.textContent = 'Tambah Kategori';
            modal.show(); // <-- PERBAIKAN 2: Gunakan .show()
        } else if (mode === 'edit' && id) {
            modalTitle.textContent = 'Edit Kategori';
            
            fetch(`${URL_EDIT}${id}`, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data) {
                    hiddenId.value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('description').value = data.description || '';
                    modal.show(); // <-- PERBAIKAN 2: Gunakan .show()
                } else {
                    showNotification('Data tidak ditemukan', 'error');
                }
            })
            .catch(err => console.error(err));
        }
    };

    // Fungsi untuk menutup modal (DIPERBAIKI)
    const closeModal = () => {
        modal.hide(); // <-- PERBAIKAN 3: Gunakan .hide()
    };

    // Fungsi notifikasi (Sama, tidak berubah)
    const showNotification = (message, type = 'success') => {
        const color = type === 'success' ? 'success' : 'danger';
        notificationArea.innerHTML = `<div class="alert alert-${color} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
    };

    // Fungsi bersihkan error (Sama, tidak berubah)
    const clearErrors = () => {
        document.getElementById('error-name').textContent = '';
        document.getElementById('error-description').textContent = '';
        // Bootstrap 5: Hapus juga class 'is-invalid'
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    };

    // --- Event Listeners ---

    // 1. Tombol Tambah
    btnAdd.addEventListener('click', () => {
        openModal('create');
    });

    // 2. Tombol Batal
    // Tidak perlu listener JS, 'data-bs-dismiss="modal"' di HTML sudah menanganinya.
    
    // 3. Submit Form (DIPERBAIKI)
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(form);
        const id = hiddenId.value;
        const url = id ? `${URL_UPDATE}${id}` : URL_STORE;
        
        const headers = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': CSRF_TOKEN 
        };

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: headers
            });

            const result = await response.json();

            if (response.status === 400) { // Gagal Validasi
                Object.keys(result).forEach(key => {
                    const errorEl = document.getElementById(`error-${key}`);
                    const inputEl = document.getElementById(key);
                    if (errorEl) errorEl.textContent = result[key];
                    if (inputEl) inputEl.classList.add('is-invalid'); // Tambahkan class error Bootstrap
                });
            } else if (response.ok) {
                showNotification(result.message, 'success');
                closeModal(); // <-- PERBAIKAN 4: Panggil fungsi .hide()
                location.reload(); // Reload halaman untuk lihat data baru
            } else {
                showNotification(result.message || 'Terjadi kesalahan.', 'error');
            }
        } catch (err) {
            console.error('Error submitting form:', err);
            showNotification('Tidak dapat terhubung ke server.', 'error');
        }
    });

    // 4. Tombol Edit dan Delete (Event Delegation)
    tableBody.addEventListener('click', async (e) => {
        // 'closest' lebih aman jika user mengklik ikon di dalam tombol
        const targetButton = e.target.closest('button'); 
        if (!targetButton) return; 

        // --- Tombol Edit ---
        if (targetButton.classList.contains('btn-edit')) {
            const id = targetButton.dataset.id;
            openModal('edit', id);
        }

        // --- Tombol Delete ---
        if (targetButton.classList.contains('btn-delete')) {
            const id = targetButton.dataset.id;
            if (confirm('Anda yakin ingin menghapus kategori ini?')) {
                
                const headers = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                };
                
                try {
                    const response = await fetch(`${URL_DELETE}${id}`, {
                        method: 'DELETE',
                        headers: headers
                    });
                    
                    const result = await response.json();

                    if(response.ok) {
                        showNotification(result.message, 'success');
                        location.reload(); // Reload halaman
                    } else {
                        showNotification(result.message || 'Gagal menghapus.', 'error');
                    }
                } catch (err) {
                    console.error('Error deleting:', err);
                    showNotification('Tidak dapat terhubung ke server.', 'error');
                }
            }
        }
    });
});