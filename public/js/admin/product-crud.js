document.addEventListener('DOMContentLoaded', () => {

    // Ambil elemen
    const container = document.getElementById('product-crud-container');
    const modal = document.getElementById('product-modal');
    const form = document.getElementById('product-form');
    const btnAdd = document.getElementById('btn-add-product');
    const btnCancel = document.getElementById('btn-cancel');
    const modalTitle = document.getElementById('modal-title');
    const hiddenId = document.getElementById('product_id');
    const tableBody = document.getElementById('product-table-body');
    const notificationArea = document.getElementById('notification-area');

    // Ambil URL
    const URL_STORE = container.dataset.storeUrl;
    const URL_EDIT = container.dataset.editUrl;
    const URL_UPDATE = container.dataset.updateUrl;
    const URL_DELETE = container.dataset.deleteUrl;

    // Ambil CSRF
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Fungsi buka modal
    const openModal = (mode = 'create', id = null) => {
        form.reset();
        clearErrors();
        hiddenId.value = '';

        if (mode === 'create') {
            modalTitle.textContent = 'Tambah Produk';
            modal.classList.remove('hidden');
        } else if (mode === 'edit' && id) {
            modalTitle.textContent = 'Edit Produk';
            
            fetch(`${URL_EDIT}${id}`, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data) {
                    hiddenId.value = data.id;
                    document.getElementById('category_id').value = data.category_id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('price_per_kg').value = data.price_per_kg;
                    document.getElementById('description').value = data.description || '';
                    modal.classList.remove('hidden');
                } else {
                    showNotification('Data tidak ditemukan', 'error');
                }
            })
            .catch(err => console.error(err));
        }
    };

    // Fungsi tutup modal
    const closeModal = () => {
        modal.classList.add('hidden');
        form.reset();
    };

    // Fungsi notifikasi
    const showNotification = (message, type = 'success') => {
        const color = type === 'success' ? 'green' : 'red';
        notificationArea.innerHTML = `<div class="bg-${color}-100 border border-${color}-400 text-${color}-700 px-4 py-3 rounded mb-4">${message}</div>`;
        setTimeout(() => { notificationArea.innerHTML = ''; }, 3000);
    };

    // Fungsi bersihkan error
    const clearErrors = () => {
        document.getElementById('error-category_id').textContent = '';
        document.getElementById('error-name').textContent = '';
        document.getElementById('error-price_per_kg').textContent = '';
        document.getElementById('error-description').textContent = '';
    };

    // --- Event Listeners ---
    btnAdd.addEventListener('click', () => openModal('create'));
    btnCancel.addEventListener('click', closeModal);

    // 3. Submit Form
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
                    if (errorEl) {
                        errorEl.textContent = result[key];
                    }
                });
            } else if (response.ok) {
                showNotification(result.message, 'success');
                closeModal();
                location.reload(); 
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
        const target = e.target;

        if (target.classList.contains('btn-edit')) {
            openModal('edit', target.dataset.id);
        }

        if (target.classList.contains('btn-delete')) {
            const id = target.dataset.id;
            if (confirm('Anda yakin ingin menghapus produk ini? (Soft Delete)')) {
                
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
                        location.reload();
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