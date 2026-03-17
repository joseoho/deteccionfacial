<!-- Core Scripts -->
<script src="{{ asset('assets/js/jquery-3.5.1.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
<script src="{{ asset('assets/vendors/js/vendor.bundle.addons.js')}}"></script>

<!-- Layout Scripts -->
<script src="{{ asset('assets/js/off-canvas.js')}}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js')}}"></script>
<script src="{{ asset('assets/js/misc.js')}}"></script>
<script src="{{ asset('assets/js/settings.js')}}"></script>
<script src="{{ asset('assets/js/todolist.js')}}"></script>
<script src="{{ asset('assets/js/dashboard.js')}}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

<!-- Custom Scripts -->
@yield('scripts')

<!-- Livewire Scripts -->
@livewireScripts

<!-- Toastr Notifications -->
<script>
  // Configuración global de toastr
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };

  // Livewire event listeners
  @if(config('livewire.enabled', false))
    window.livewire.on('msgok', msgOK => {
      toastr.success(msgOK, "Éxito");
    });

    window.livewire.on('msg-error', msgError => {
      toastr.error(msgError, "Error");
    });
  @endif

  // Auto-dismiss alerts after 5 seconds
  $(document).ready(function() {
    setTimeout(function() {
      $('.alert').fadeOut('slow', function() {
        $(this).remove();
      });
    }, 5000);
  });

  // Smooth scroll for anchor links
  $('a[href^="#"]').on('click', function(event) {
    var target = $(this.getAttribute('href'));
    if( target.length ) {
      event.preventDefault();
      $('html, body').stop().animate({
        scrollTop: target.offset().top - 70
      }, 1000);
    }
  });
</script>
