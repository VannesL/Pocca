$('.btn-plus, .btn-minus').on('click', function(e) {
    const isNegative = $(this).is('.btn-minus');
    const input = $(this).closest('.input-group').find('[name=quantity]');
    if (input.is('input')) {
      input[0][isNegative ? 'stepDown' : 'stepUp']()
    }
  })