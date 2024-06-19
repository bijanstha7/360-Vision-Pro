<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>
                    document.write(new Date().getFullYear())

                </script> © 360_Vision_Pro
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by <a href="https://bijanshrestha.com.np/">Bijan Shrestha</a> 
                </div>
            </div>
        </div>
    </div>
</footer>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
   
    var Toast = Swal.mixin({
        toast: true
        , position: 'top-end'
        , showConfirmButton: false,
        timer: 5000,
        showCloseButton: true,
        //timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    @if(session()->has('success'))
    Toast.fire({
        icon: 'success',
        title: '{{ session()->get('success') }}'
    })
    @endif
    @if(session()->has('warning'))
    Toast.fire({
        icon: 'warning',
        title: '{{ session()->get('warning') }}'
    })
    @endif

</script>
