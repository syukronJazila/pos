@php
    $category_max_id = \Modules\Product\Entities\Category::max('id') + 1;
    $category_code = "CA_" . str_pad($category_max_id, 2, '0', STR_PAD_LEFT);
@endphp

<div class="modal fade" id="categoryCreateModal" tabindex="-1" role="dialog" aria-labelledby="categoryCreateModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryCreateModalLabel">Create Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="category-form" action="{{ route('product-categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category_code">Category Code <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="category_code" required value="{{ $category_code }}">
                    </div>
                    <div class="form-group">
                        <label for="category_name">Category Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="category_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create <i class="bi bi-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Pastikan jQuery dimuat terlebih dahulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Kemudian muat toastr.js setelah jQuery -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    $(document).ready(function () {
        $('#category-form').on('submit', function (e) {
            e.preventDefault(); // Mencegah submit form secara default

            $.ajax({
                url: $(this).attr('action'), // URL dari action form
                type: 'POST',
                data: $(this).serialize(), // Data form yang dikirim
                success: function (response) {
                    // Menutup modal dengan delay agar toast sempat tampil
                    setTimeout(function () {
                        $('#categoryCreateModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');

                        // Memperbarui dropdown kategori
                        $('#category_id').append(new Option(response.category_name, response.category_id));

                        // Mengaktifkan kembali scroll jika terkunci
                        $('body').css('overflow', 'auto');

                        // Menampilkan notifikasi toast
                        toastr.success('Product Category Created!', 'Success');
                    }, 100); // Delay 100ms untuk memberi waktu toast tampil
                },
                error: function (xhr) {
                    // Menampilkan pesan error jika terjadi kegagalan
                    toastr.error('Failed to create category', 'Error');
                }
            });
        });
    });
</script>
