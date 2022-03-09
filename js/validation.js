$('#product').validate({
    rules: {
      sku: {
        remote: {
          url: 'index.php',
          type: 'post',
          async: false,
          data: {
            'sku_id': $('#sku').val(),
           
          },

        }
      },
    },


    messages: {
      sku: {  
        remote: 'SKU already exists'
      },


    },
    errorElement: 'div',
    errorPlacement: function (error, element) {
      var placement = $(element).data('error')
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element)
      }
    }
  })