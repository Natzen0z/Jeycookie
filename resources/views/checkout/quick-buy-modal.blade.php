<!-- Modal untuk Guest Quick Buy -->
<div class="modal fade" id="quickBuyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-gradient border-0 pb-4">
                <h5 class="modal-title fw-bold" style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: #be185d;">
                    Beli Sekarang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <!-- Product Info -->
                <div class="alert alert-info mb-4 rounded-3" style="background: linear-gradient(135deg, rgba(236, 72, 153, 0.1), rgba(236, 72, 153, 0.05)); border: 1px solid rgba(236, 72, 153, 0.2);">
                    <small style="font-family: 'Poppins', sans-serif;">
                        <strong id="productNameDisplay" style="font-size: 1.1rem; color: #be185d;"></strong> 
                        <br class="my-2">
                        <span style="color: #666;">Jumlah:</span> <strong id="quantityDisplay" style="color: #be185d;">1</strong>
                        <br>
                        <span style="color: #666;">Total:</span> <strong id="totalDisplay" style="font-size: 1.2rem; color: #ec4899;"></strong>
                    </small>
                </div>

                <!-- Form -->
                <form id="quickBuyForm">
                    @csrf
                    <input type="hidden" id="productId">
                    <input type="hidden" id="quantity" name="quantity" value="1">
                    
                    <div class="mb-3">
                        <label for="customer_name" class="form-label fw-600" style="font-family: 'Poppins', sans-serif; color: #374151;">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control rounded-3 border-2" 
                               id="customer_name" 
                               name="customer_name"
                               placeholder="Nama lengkap Anda"
                               style="border-color: #f3e8f0; padding: 0.75rem 1rem; font-family: 'Poppins', sans-serif;"
                               required>
                        <small class="text-danger d-none" id="customerNameError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="customer_phone" class="form-label fw-600" style="font-family: 'Poppins', sans-serif; color: #374151;">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="tel" 
                               class="form-control rounded-3 border-2" 
                               id="customer_phone" 
                               name="customer_phone"
                               placeholder="08xxxxxxxxxx"
                               style="border-color: #f3e8f0; padding: 0.75rem 1rem; font-family: 'Poppins', sans-serif;"
                               required>
                        <small class="text-danger d-none" id="customerPhoneError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="customer_email" class="form-label fw-600" style="font-family: 'Poppins', sans-serif; color: #374151;">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control rounded-3 border-2" 
                               id="customer_email" 
                               name="customer_email"
                               placeholder="email@contoh.com"
                               style="border-color: #f3e8f0; padding: 0.75rem 1rem; font-family: 'Poppins', sans-serif;"
                               required>
                        <small class="text-muted" style="font-family: 'Poppins', sans-serif;">Untuk notifikasi status pembayaran</small>
                        <small class="text-danger d-none" id="customerEmailError"></small>
                    </div>

                    <div class="mb-4">
                        <label for="customer_address" class="form-label fw-600" style="font-family: 'Poppins', sans-serif; color: #374151;">Alamat Pengiriman <span class="text-danger">*</span></label>
                        <textarea class="form-control rounded-3 border-2" 
                                  id="customer_address" 
                                  name="customer_address"
                                  rows="3"
                                  placeholder="Jalan, No., RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos"
                                  style="border-color: #f3e8f0; padding: 0.75rem 1rem; font-family: 'Poppins', sans-serif; resize: none;"
                                  required></textarea>
                        <small class="text-danger d-none" id="customerAddressError"></small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-pink btn-lg rounded-3" id="submitBtn" style="font-family: 'Poppins', sans-serif; font-weight: 600; padding: 0.875rem 1.5rem;">
                            Lanjut ke Pembayaran
                        </button>
                        <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal" style="font-family: 'Poppins', sans-serif; font-weight: 600;">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Global variable untuk menyimpan snap token
let snapToken = null;

// Fungsi untuk open modal quick buy
function openQuickBuyModal(productId, productName, productPrice, maxStock = 999) {
    // Reset form
    document.getElementById('quickBuyForm').reset();
    document.querySelectorAll('.text-danger').forEach(el => el.classList.add('d-none'));
    
    // Set product info
    document.getElementById('productId').value = productId;
    document.getElementById('quantity').value = 1;
    document.getElementById('productNameDisplay').textContent = productName;
    document.getElementById('quantityDisplay').textContent = '1';
    document.getElementById('totalDisplay').textContent = 'Rp' + formatCurrency(productPrice);
    
    // Update total ketika quantity berubah
    document.getElementById('quantity').addEventListener('change', function() {
        const qty = parseInt(this.value) || 1;
        if (qty > maxStock) {
            this.value = maxStock;
            alert('Stok maksimal: ' + maxStock);
            return;
        }
        document.getElementById('quantityDisplay').textContent = qty;
        document.getElementById('totalDisplay').textContent = 'Rp' + formatCurrency(productPrice * qty);
    });
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('quickBuyModal'));
    modal.show();
}

// Format currency
function formatCurrency(value) {
    return new Intl.NumberFormat('id-ID').format(Math.round(value));
}

// Handle form submit
document.getElementById('quickBuyForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Memproses...';
    
    // Clear previous errors
    document.querySelectorAll('.text-danger').forEach(el => el.classList.add('d-none'));
    
    try {
        const productId = document.getElementById('productId').value;
        const response = await fetch(`/products/${productId}/quick-buy`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                customer_name: document.getElementById('customer_name').value,
                customer_phone: document.getElementById('customer_phone').value,
                customer_email: document.getElementById('customer_email').value,
                customer_address: document.getElementById('customer_address').value,
                quantity: parseInt(document.getElementById('quantity').value)
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            snapToken = data.snap_token;
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('quickBuyModal')).hide();
            
            // Show Snap payment modal
            snap.pay(snapToken, {
                onSuccess: function(result){
                    console.log('Payment success:', result);
                    window.location.href = `/orders/${data.order_number}`;
                },
                onPending: function(result){
                    console.log('Payment pending:', result);
                    alert('Pembayaran sedang diproses. Silakan tunggu...');
                },
                onError: function(result){
                    console.log('Payment error:', result);
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    location.reload();
                },
                onClose: function(){
                    console.log('Payment modal closed');
                    alert('Anda menutup jendela pembayaran');
                }
            });
        } else {
            // Show error message
            if (data.message.includes('Nama')) {
                document.getElementById('customerNameError').textContent = data.message;
                document.getElementById('customerNameError').classList.remove('d-none');
            } else if (data.message.includes('Telepon')) {
                document.getElementById('customerPhoneError').textContent = data.message;
                document.getElementById('customerPhoneError').classList.remove('d-none');
            } else if (data.message.includes('Email')) {
                document.getElementById('customerEmailError').textContent = data.message;
                document.getElementById('customerEmailError').classList.remove('d-none');
            } else if (data.message.includes('Alamat')) {
                document.getElementById('customerAddressError').textContent = data.message;
                document.getElementById('customerAddressError').classList.remove('d-none');
            } else {
                alert(data.message);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});
</script>
