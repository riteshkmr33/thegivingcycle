/*
 * UnderConstructionPage
 * Backend GUI pointers
 * (c) Web factory Ltd, 2015 - 2017
 */


jQuery(document).ready(function($){
  if (typeof ucp_pointers  == 'undefined') {
    return;
  }

  $.each(ucp_pointers, function(index, pointer) {
    if (index.charAt(0) == '_') {
      return true;
    }
    $(pointer.target).pointer({
        content: '<h3>' + ucp_vars.plugin_name + '</h3><p>' + pointer.content + '</p>',
        position: {
            edge: pointer.edge,
            align: pointer.align
        },
        width: 320,
        close: function() {
                $.post(ajaxurl, {
                    pointer: index,
                    _ajax_nonce: ucp_pointers._nonce_dismiss_pointer,
                    action: 'ucp_dismiss_pointer'
                });
        }
      }).pointer('open');
  });
});
