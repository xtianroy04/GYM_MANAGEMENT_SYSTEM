crud.field('type').onChange(function(field) {
    crud.field('transaction_code').show(field.value == 'gcash');
  }).change();

