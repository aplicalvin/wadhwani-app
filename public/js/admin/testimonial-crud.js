document.addEventListener('DOMContentLoaded', () => {

    // Ambil elemen
    const container = document.getElementById('testimonial-crud-container');
    const modal = document.getElementById('testimonial-modal');
    const form = document.getElementById('testimonial-form');
    const btnAdd = document.getElementById('btn-add-testimonial');
    const btnCancel = document.getElementById('btn-cancel');
    const modalTitle = document.getElementById('modal-title');
    const hiddenId = document.getElementById('testimonial_id');
    const tableBody = document.getElementById('testimonial-table-body');
    const notificationArea = document.getElementById('notification-area');

    // Ambil URL
    const URL_STORE = container.dataset.storeUrl;
    const URL_EDIT = container.dataset.editUrl;
    const URL_UPDATE = container.dataset.updateUrl;
    const URL_DELETE = container.dataset.deleteUrl;

    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Buka modal
    const openModal = (mode = 'create', id = null) => {
        form.reset();
        clearErrors();
        hiddenId.value = '';

        if (mode === 'create') {
            modalTitle.textContent = 'Tambah Testimoni';
            modal.classList.remove('hidden');
        } else if (mode === 'edit' && id) {
            modalTitle.textContent = 'Edit Testimoni';
            
            fetch(`${URL_EDIT}${id}`, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if (data) {
                    hiddenId.value = data.id;
                    document.getElementById('customer_name').value = data.customer_name;
                    document.getElementById('body').value = data.body || '';
                    document.getElementById('rating').value = data.rating || '';
                    document.getElementById('status').value = data.status;
                    modal.classList.remove('hidden');
                } else {
                    showNotification('Data tidak ditemukan', 'error');
                }
            })
            .catch(err => console.error(err));
        }
    };

    const closeModal = () => modal.classList.add('hidden');
    
    const showNotification = (message, type = 'success') => {
        const color = type === 'success' ? 'green' : 'red';
        notificationArea.innerHTML = `<div class="bg-${color}-100 border border-${color}-400 text-${color}-700 px-4 py-3 rounded mb-4">${message}</div>`;
        setTimeout(() => { notificationArea.innerHTML = ''; }, 3000);
    };

    const clearErrors = () => {
        document.getElementById('error-customer_name').textContent = '';
        document.getElementById('error-body').textContent = '';
        document.getElementById('error-rating').textContent = '';
        document.getElementById('error-status').textContent = '';
    };

    // --- Event Listeners ---
    btnAdd.addEventListener('click', () => openModal('create'));
    btnCancel.addEventListener('click', closeModal);

    // Submit Form
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
            const response = await fetch(url, { method: 'POST', body: formData, headers: headers });
            const result = await response.json();

            if (response.status === 400) { // Gagal Validasi
                Object.keys(result).forEach(key => {
                    const errorEl = document.getElementById(`error-${key}`);
                    if (errorEl) errorEl.textContent = result[key];
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

    // Edit dan Delete
    tableBody.addEventListener('click', async (e) => {
        const target = e.target;
        if (target.classList.contains('btn-edit')) {
            openModal('edit', target.dataset.id);
        }
        if (target.classList.contains('btn-delete')) {
            const id = target.dataset.id;
            if (confirm('Anda yakin ingin menghapus testimoni ini?')) {
                const headers = { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF_TOKEN };
                try {
                    const response = await fetch(`${URL_DELETE}${id}`, { method: 'DELETE', headers: headers });
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